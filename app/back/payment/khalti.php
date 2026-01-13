<?php
if (!defined('PAYMENT')) {
    http_response_code(404);
    die();
}

$liveSecretKey = $methodExtras["liveSecretKey"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (route(2) == "callback") {
        $pidx = $_GET["pidx"] ?? null;
        
        if (!$pidx) {
            errorExit("Invalid payment reference.");
        }
        
        $paymentExists = $conn->prepare("SELECT payment_extra FROM payments WHERE payment_extra=:pidx");
        $paymentExists->execute([
            "pidx" => $pidx
        ]);
        if ($paymentExists->rowCount()) {
            errorExit("Payment already processed.");
        }
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://khalti.com/api/v2/epayment/lookup/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'pidx' => $pidx
            ]),
            CURLOPT_HTTPHEADER => array(
                'Authorization: key ' . $liveSecretKey,
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $result = json_decode($response, true);

        if ($httpCode == 200 && isset($result['status']) && $result['status'] === 'Completed') {
            $paidAmountPaisa = $result['total_amount'];
            $paidAmount = $paidAmountPaisa / 100;
            $transactionId = $result['transaction_id'];
            
            $insert = $conn->prepare("INSERT INTO payments (client_id, payment_amount, payment_method, payment_mode, payment_create_date, payment_ip, payment_extra) VALUES (:client_id, :amount, :method, :mode, :date, :ip, :extra) RETURNING payment_id");
            $insert->execute([
                "client_id" => $user["client_id"],
                "amount" => $paidAmount,
                "method" => $methodId,
                "mode" => "Automatic",
                "date" => date("Y.m.d H:i:s"),
                "ip" => GetIP(),
                "extra" => $pidx
            ]);
            $paymentResult = $insert->fetch(PDO::FETCH_ASSOC);
            $paymentId = $paymentResult['payment_id'];
            
            $finalAmount = $paidAmount;
            if ($paymentFee > 0) {
                $fee = ($finalAmount * ($paymentFee / 100));
                $finalAmount -= $fee;
            }
            if ($paymentBonusStartAmount != 0 && $finalAmount > $paymentBonusStartAmount) {
                $bonus = $finalAmount * ($paymentBonus / 100);
                $finalAmount += $bonus;
            }
            $finalAmount = from_to($currencies_array, $methodCurrency, $settings["site_base_currency"], $finalAmount);

            $update = $conn->prepare('UPDATE payments SET 
                    client_balance=:balance,
                    payment_status=:status, 
                    payment_delivery=:delivery WHERE payment_id=:id');
            $update->execute([
                'balance' => $user["balance"],
                'status' => 3,
                'delivery' => 2,
                'id' => $paymentId
            ]);

            $balance = $conn->prepare('UPDATE clients SET balance=:balance WHERE client_id=:id');
            $balance->execute([
                "balance" => $user["balance"] + $finalAmount,
                "id" => $user["client_id"]
            ]);
            
            $response = [];
            $response["success"] = true;
            $response["message"] = "Payment successful! NPR " . number_format($paidAmount, 2) . " has been added to your account.";
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode($response, true);
        } else {
            $status = $result['status'] ?? 'Unknown';
            errorExit("Payment verification failed. Status: " . $status);
        }
        exit;
    }
    
    $paymentAmount = floatval($_POST["paymentAmount"]);
    
    if ($paymentAmount < $methodMin || $paymentAmount > $methodMax) {
        errorExit("Amount must be between " . $methodCurrencySymbol . $methodMin . " and " . $methodCurrencySymbol . $methodMax);
    }
    
    $amountInPaisa = intval($paymentAmount * 100);
    $orderId = 'ORDER-' . $user["client_id"] . '-' . time();
    
    $returnUrl = site_url('khalti/callback');
    $websiteUrl = site_url('');
    
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://khalti.com/api/v2/epayment/initiate/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode([
            'return_url' => $returnUrl,
            'website_url' => $websiteUrl,
            'amount' => $amountInPaisa,
            'purchase_order_id' => $orderId,
            'purchase_order_name' => 'Account Top-up',
            'customer_info' => [
                'name' => $user["client_name"] ?? 'Customer',
                'email' => $user["client_email"] ?? '',
                'phone' => $user["client_phone"] ?? ''
            ]
        ]),
        CURLOPT_HTTPHEADER => array(
            'Authorization: key ' . $liveSecretKey,
            'Content-Type: application/json',
        ),
    ));

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    $data = json_decode($response, true);

    if ($httpCode == 200 && isset($data['payment_url'])) {
        $response = [];
        $response["success"] = true;
        $response["redirect"] = $data['payment_url'];
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($response, true);
    } else {
        $errorMsg = $data['detail'] ?? $data['error'] ?? 'Failed to initiate payment';
        errorExit($errorMsg);
    }
    exit;
    
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    if (route(2) == "callback") {
        $pidx = $_GET["pidx"] ?? null;
        $status = $_GET["status"] ?? null;
        
        if ($status === "Completed" && $pidx) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://khalti.com/api/v2/epayment/lookup/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode([
                    'pidx' => $pidx
                ]),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: key ' . $liveSecretKey,
                    'Content-Type: application/json',
                ),
            ));

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            $result = json_decode($response, true);

            if ($httpCode == 200 && isset($result['status']) && $result['status'] === 'Completed') {
                $paymentExists = $conn->prepare("SELECT payment_extra FROM payments WHERE payment_extra=:pidx");
                $paymentExists->execute([
                    "pidx" => $pidx
                ]);
                
                if (!$paymentExists->rowCount()) {
                    $paidAmountPaisa = $result['total_amount'];
                    $paidAmount = $paidAmountPaisa / 100;
                    $transactionId = $result['transaction_id'];
                    
                    $insert = $conn->prepare("INSERT INTO payments (client_id, payment_amount, payment_method, payment_mode, payment_create_date, payment_ip, payment_extra) VALUES (:client_id, :amount, :method, :mode, :date, :ip, :extra)");
                    $insert->execute([
                        "client_id" => $user["client_id"],
                        "amount" => $paidAmount,
                        "method" => $methodId,
                        "mode" => "Automatic",
                        "date" => date("Y.m.d H:i:s"),
                        "ip" => GetIP(),
                        "extra" => $pidx
                    ]);
                    $paymentId = $conn->lastInsertId();
                    
                    $finalAmount = $paidAmount;
                    if ($paymentFee > 0) {
                        $fee = ($finalAmount * ($paymentFee / 100));
                        $finalAmount -= $fee;
                    }
                    if ($paymentBonusStartAmount != 0 && $finalAmount > $paymentBonusStartAmount) {
                        $bonus = $finalAmount * ($paymentBonus / 100);
                        $finalAmount += $bonus;
                    }
                    $finalAmount = from_to($currencies_array, $methodCurrency, $settings["site_base_currency"], $finalAmount);

                    $update = $conn->prepare('UPDATE payments SET 
                            client_balance=:balance,
                            payment_status=:status, 
                            payment_delivery=:delivery WHERE payment_id=:id');
                    $update->execute([
                        'balance' => $user["balance"],
                        'status' => 3,
                        'delivery' => 2,
                        'id' => $paymentId
                    ]);

                    $balance = $conn->prepare('UPDATE clients SET balance=:balance WHERE client_id=:id');
                    $balance->execute([
                        "balance" => $user["balance"] + $finalAmount,
                        "id" => $user["client_id"]
                    ]);
                }
                
                header("Location: " . site_url("addfunds?success=1"));
                exit;
            }
        }
        
        header("Location: " . site_url("addfunds?error=1"));
        exit;
    }
    
    http_response_code(405);
    die();
}
