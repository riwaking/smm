<?php
if (!defined('BASEPATH')) {
    die('Direct access to the script is not allowed');
}
define("ADDFUNDS", TRUE);
$title .= " Add Funds";

if ($_SESSION["msmbilisim_userlogin"] != 1 || $user["client_type"] == 1) {
    header("Location:" . site_url('logout'));
}
if ($settings["email_confirmation"] == 1 && $user["email_type"] == 1) {
    header("Location:" . site_url('confirm_email'));
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $paymentMethods = $conn->prepare("SELECT * FROM paymentmethods WHERE methodstatus=:status ORDER BY methodposition ASC");
    $paymentMethods->execute(["status" => '1']);

    $methodsList = array();

    if ($paymentMethods->rowCount()) {
        $paymentMethods = $paymentMethods->fetchAll(PDO::FETCH_ASSOC);
        for ($i = 0; $i < count($paymentMethods); $i++) {
            $methodsList[] = [
                "id" => $paymentMethods[$i]["methodid"],
                "name" => $paymentMethods[$i]["methodvisiblename"],
                "instructions" => trim(htmlspecialchars_decode($paymentMethods[$i]["methodinstructions"] ?? '')),
                "fee" => $paymentMethods[$i]["methodfee"]
            ];
            $paymentMethodsJSON = json_encode(array_group_by($methodsList, "id"), 1);
        }
    } else {
        $methodsList[] = [
            "id" => 0,
            "name" => "No payment gateway activated"
        ];
    }



    $methodNames = $conn->prepare("SELECT methodid,methodvisiblename FROM paymentmethods");
    $methodNames->execute();
    $methodNames = $methodNames->fetchAll(PDO::FETCH_ASSOC);
    $methodNames = array_group_by($methodNames, "methodid");


    $transactions = $conn->prepare("SELECT payment_id,payment_create_date,payment_method,payment_amount FROM payments WHERE payment_status=:status AND payment_delivery=:delivery AND client_id=:id ORDER BY payment_id DESC");
    $transactions->execute([
        "status" => 3,
        "delivery" => 2,
        "id" => $user["client_id"]
    ]);
    $transactions = $transactions->fetchAll(PDO::FETCH_ASSOC);

    $paymentHistory = [];
    for ($i = 0; $i < count($transactions); $i++) {
        $paymentHistory[] = [
            "id" => $transactions[$i]["payment_id"],
            "date" => $transactions[$i]["payment_create_date"],
            "name" => $methodNames[$transactions[$i]["payment_method"]][0]["methodvisiblename"] ?? 'Unknown',
            "amount" => format_amount_string($user["currency_type"], from_to($currencies_array, $settings["site_base_currency"], $user["currency_type"], $transactions[$i]["payment_amount"]))
        ];
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["action"] == "getForm") {
    $formData .= "";
    $selectedMethod = $_POST["selectedMethod"];
    include("addfunds/getForm.php");
    $response = [];
    $response["success"] = true;
    $response["content"] = $formData;
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode($response, true);
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $methodId = intval($_POST["payment_type"] ?: 0);

    $method = $conn->prepare("SELECT * FROM paymentmethods WHERE methodid=:id AND methodstatus=:status");
    $method->execute([
        "id" => $methodId,
        "status" => '1'
    ]);
    if ($method->rowCount()) {
        $method = $method->fetch(PDO::FETCH_ASSOC);
        $methodId = $method["methodid"];
        $methodMin = number_format($method["methodmin"], 2, '.', '');
        $methodMax = number_format($method["methodmax"], 2, '.', '');
        $methodCurrency = $method["methodcurrency"];
        $methodCurrencySymbol = $currencies_array[$methodCurrency][0]["currency_symbol"] ?? $methodCurrency;
        $methodCallback = $method["methodcallback"];
        $methodExtras = json_decode($method["methodextras"], 1);
        $paymentFee = $method["methodfee"];
        $paymentBonus = $method["methodbonuspercentage"];
        $paymentBonusStartAmount = $method["methodbonusstartamount"];

        $paymentAmount = floatval($_POST["payment_amount"] ?: 0);
        if ($paymentFee > 0) {
            $fee = ($paymentAmount * ($paymentFee / 100));
            $paymentAmount += $fee;
        }
        $response = [];

        if ($paymentAmount < $methodMin) {
            errorExit("Minimum amount : $methodCurrencySymbol $methodMin");
        }
        if ($paymentAmount > $methodMax) {
            errorExit("Maximum amount : $methodCurrencySymbol $methodMax");
        }
        if ($method["methodid"] == 2) {
            require("addfunds/Initiators/payTMMerchant.php");
        }
        if ($method["methodid"] == 3) {
            require("addfunds/Initiators/perfectMoney.php");
        }
        if ($method["methodid"] == 4) {
            require("addfunds/Initiators/coinbaseCommerce.php");
        }
        if ($method["methodid"] == 5) {
            require("addfunds/Initiators/kashier.php");
        }
        if ($method["methodid"] == 6) {
            require("addfunds/Initiators/razorPay.php");
        }
        if ($method["methodid"] == 54) {
            require("addfunds/Initiators/paypal.php");
        }
        if ($method["methodid"] == 7) {
            require("addfunds/Initiators/phonepe.php");
        }
        if ($method["methodid"] == 8) {
            require("addfunds/Initiators/easypaisa.php");
        }
        if ($method["methodid"] == 9) {
            require("addfunds/Initiators/jazzcash.php");
        }
        if ($method["methodid"] == 10) {
            require("addfunds/Initiators/instamojo.php");
        }
        if ($method["methodid"] == 56) {
            require("addfunds/Initiators/binance_auto.php");
        }
        if ($method["methodid"] == 11) {
            require("addfunds/Initiators/cashmaal.php");
        }
        if ($method["methodid"] == 12) {
            require("addfunds/Initiators/alipay.php");
        }
        if ($method["methodid"] == 13) {
            require("addfunds/Initiators/payU.php");
        }
        if ($method["methodid"] == 14) {
            require("addfunds/Initiators/upiapi.php");
        }
         if ($method["methodid"] == 14) {
            require("addfunds/Initiators/binance.php");
        }
        if ($method["methodid"] == 15) {
            require("addfunds/Initiators/opay.php");
        }
        if ($method["methodid"] == 16) {
            require("addfunds/Initiators/flutterwave.php");
        }
        if ($method["methodid"] == 17) {
            require("addfunds/Initiators/stripe.php");
        }
        if ($method["methodid"] == 18) {
            require("addfunds/Initiators/payeer.php");
        }
         if ($method["methodid"] == 29) {
            require("addfunds/Initiators/heleket.php");
        }
        
         if ($method["methodid"] == 55) {
            require("addfunds/Initiators/mercadopago.php");
        }
        if ($method["methodid"] == 1) {
            require("addfunds/Initiators/manual.php");
        }
        if ($method["methodid"] == 20) {
            require("addfunds/Initiators/khalti.php");
        }
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($response, true);
        exit;
    } else {
        errorExit("Select a valid payment method.");
    }
}
?>