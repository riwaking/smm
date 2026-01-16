<?php
if (!defined('BASEPATH')) {
    die('Direct access to the script is not allowed');
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["action"]) && $_GET["action"] == "getData") {
        $clients = $conn->prepare("SELECT client_id, username FROM clients");
        $clients->execute();
        $clients = $clients->fetchAll(PDO::FETCH_ASSOC);
        $clients = array_group_by($clients, "client_id");
        $payments = $conn->prepare("SELECT payment_id, client_id, client_balance, payment_amount, payment_method, payment_status, payment_delivery, payment_note, payment_mode, payment_extra, payment_create_date FROM payments ORDER BY payment_id DESC");
        $payments->execute();
        $payments = $payments->fetchAll(PDO::FETCH_ASSOC);
        $methods = $conn->prepare("SELECT methodid,methodvisiblename FROM paymentmethods");
        $methods->execute();
        $methods = $methods->fetchAll(PDO::FETCH_ASSOC);
        $methods = array_group_by($methods, "methodid");
        $PAYMENTS = [];
        for ($i = 0; $i < count($payments); $i++) {
            $isPending = false;
            if ($payments[$i]["payment_status"] == 1 AND $payments[$i]["payment_delivery"] == 1) {
                $paymentStatus = '<span class="badge bg-warning text-dark">Pending</span>';
                $isPending = true;
            } elseif ($payments[$i]["payment_status"] == 3 AND $payments[$i]["payment_delivery"] == 2) {
                $paymentStatus = '<span class="badge bg-success">Completed</span>';
            } elseif ($payments[$i]["payment_status"] == 2 AND $payments[$i]["payment_delivery"] == 2) {
                $paymentStatus = '<span class="badge bg-danger">Rejected</span>';
            } else {
                $paymentStatus = '<span class="badge bg-secondary">Unknown</span>';
            }
            
            $methodName = "Unknown";
            $paymentMethodId = $payments[$i]["payment_method"];
            if ($paymentMethodId !== null && isset($methods[$paymentMethodId]) && isset($methods[$paymentMethodId][0])) {
                $methodName = $methods[$paymentMethodId][0]["methodvisiblename"];
            } elseif (!empty($payments[$i]["payment_mode"])) {
                $methodName = $payments[$i]["payment_mode"];
            }
            
            $clientUsername = "Unknown";
            $clientId = $payments[$i]["client_id"];
            if ($clientId !== null && isset($clients[$clientId]) && isset($clients[$clientId][0])) {
                $clientUsername = $clients[$clientId][0]["username"];
            }
            
            $PAYMENTS[] = [
                "id" => $payments[$i]["payment_id"],
                "cid" => $payments[$i]["client_id"],
                "username" => $clientUsername,
                "method" => $methodName,
                "user_balance" => number_format($payments[$i]["client_balance"] ?? 0, 2, '.', ''),
                "amount" => number_format($payments[$i]["payment_amount"] ?? 0, 2, '.', ''),
                "status" => $paymentStatus,
                "mode" => $payments[$i]["payment_mode"],
                "extra" => $payments[$i]["payment_extra"],
                "created_at" => date("m-d-Y h:i A", strtotime($payments[$i]["payment_create_date"])),
                "is_pending" => $isPending
            ];
        }
        header("Content-Type: application/json");
        echo json_encode($PAYMENTS);
        exit;
    }
    if (isset($_GET["action"]) && $_GET["action"] == "add_remove_balance") {
        $methods = $conn->prepare("SELECT methodid,methodvisiblename FROM paymentmethods");
        $methods->execute();
        $methods = $methods->fetchAll(PDO::FETCH_ASSOC);
        $select = "";
        for ($i = 0; $i < count($methods); $i++) {
            $select .= '<option value="' . $methods[$i]["methodid"] . '">' . $methods[$i]["methodvisiblename"] . '</option>';
        }
        $form = '<form method="POST" action="admin/fund-add-history/manage-funds">';

        $form .= '<div class="form-group mb-3"><label class="form-label">Username</label>
<input type="text"  name="username" class="form-control" required/></div>';
        $form .= '<div class="form-group mb-3"><label class="form-label">Amount</label>
<input type="number"  name="amount" class="form-control" step="0.01" required /></div>';
        $form .= '<div class="form-group mb-3"><label class="form-label">Method</label><select class="form-select" name="method">' . $select . '</select></div>';
        $form .= '<div class="form-group mb-3"><label class="form-label">Action</label><select class="form-select" name="action"><option value="add">Add</option><option value="deduct">Deduct</option></select></div>';
        $form .= '<div class="form-group mb-3"><label class="form-label">Order ID</label><input type="text"  name="orderId" class="form-control" /></div>';
        $form .= '<div class="custom-modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>&nbsp;&nbsp;<button type="submit" data-loading-text="Updating..." class="btn btn-primary">Apply</button></div></form>';
        $response = [
            "success" => true,
            "content" => $form
        ];

        header("Content-Type: application/json");
        echo json_encode($response);
        exit;
    }



}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = isset($_POST["action"]) ? $_POST["action"] : "";
    
    if ($action == "approve_payment") {
        header("Content-Type: application/json");
        $paymentId = intval($_POST["payment_id"]);
        
        try {
            $conn->beginTransaction();
            
            $payment = $conn->prepare("SELECT payment_id, client_id, payment_amount, payment_status, payment_delivery FROM payments WHERE payment_id = :id FOR UPDATE");
            $payment->execute(["id" => $paymentId]);
            $payment = $payment->fetch(PDO::FETCH_ASSOC);
            
            if (!$payment) {
                $conn->rollBack();
                echo json_encode(["success" => false, "message" => "Payment not found."]);
                exit;
            }
            
            if ($payment["payment_status"] != 1 || $payment["payment_delivery"] != 1) {
                $conn->rollBack();
                echo json_encode(["success" => false, "message" => "Payment has already been processed."]);
                exit;
            }
            
            $client = $conn->prepare("SELECT client_id, balance FROM clients WHERE client_id = :id FOR UPDATE");
            $client->execute(["id" => $payment["client_id"]]);
            $client = $client->fetch(PDO::FETCH_ASSOC);
            
            if (!$client) {
                $conn->rollBack();
                echo json_encode(["success" => false, "message" => "Client not found."]);
                exit;
            }
            
            $update = $conn->prepare("UPDATE payments SET payment_status = 3, payment_delivery = 2 WHERE payment_id = :id");
            $update->execute(["id" => $paymentId]);
            
            $newBalance = $client["balance"] + $payment["payment_amount"];
            $updateBalance = $conn->prepare("UPDATE clients SET balance = :balance WHERE client_id = :id");
            $updateBalance->execute([
                "balance" => $newBalance,
                "id" => $client["client_id"]
            ]);
            
            $conn->commit();
            echo json_encode(["success" => true, "message" => "Payment approved and funds added to user balance."]);
            exit;
        } catch (Exception $e) {
            $conn->rollBack();
            echo json_encode(["success" => false, "message" => "Error processing payment."]);
            exit;
        }
    }
    
    if ($action == "reject_payment") {
        header("Content-Type: application/json");
        $paymentId = intval($_POST["payment_id"]);
        
        try {
            $conn->beginTransaction();
            
            $payment = $conn->prepare("SELECT payment_id, payment_status, payment_delivery FROM payments WHERE payment_id = :id FOR UPDATE");
            $payment->execute(["id" => $paymentId]);
            $payment = $payment->fetch(PDO::FETCH_ASSOC);
            
            if (!$payment) {
                $conn->rollBack();
                echo json_encode(["success" => false, "message" => "Payment not found."]);
                exit;
            }
            
            if ($payment["payment_status"] != 1 || $payment["payment_delivery"] != 1) {
                $conn->rollBack();
                echo json_encode(["success" => false, "message" => "Payment has already been processed."]);
                exit;
            }
            
            $update = $conn->prepare("UPDATE payments SET payment_status = 2, payment_delivery = 2 WHERE payment_id = :id");
            $update->execute(["id" => $paymentId]);
            
            $conn->commit();
            echo json_encode(["success" => true, "message" => "Payment rejected."]);
            exit;
        } catch (Exception $e) {
            $conn->rollBack();
            echo json_encode(["success" => false, "message" => "Error processing payment."]);
            exit;
        }
    }
    
    $username = htmlspecialchars(trim($_POST["username"] ?? ""));
    $amount = floatval($_POST["amount"] ?? 0);
    $methodId = intval($_POST["method"] ?? 0);
    $orderId = htmlspecialchars($_POST["orderId"] ?? "");

    $client = $conn->prepare("SELECT client_id, balance FROM clients WHERE username=:username");
    $client->execute([
        "username" => $username
    ]);
    $client = $client->fetch(PDO::FETCH_ASSOC);

    if (!$client) {
        success_response_exit("User not found.");
    }

    if ($action == "add") {
        $conn->beginTransaction();
        $insert = $conn->prepare("INSERT INTO payments (client_id, client_balance, payment_amount, payment_method, payment_status, payment_delivery, payment_mode, payment_create_date, payment_ip, payment_extra) VALUES (:cid, :balance, :amount, :method, :status, :delivery, :mode, :date, :ip, :extra)");
        $insert->execute([
            "cid" => $client["client_id"],
            "balance" => $client["balance"],
            "amount" => +$amount,
            "method" => $methodId,
            "status" => 3,
            "delivery" => 2,
            "mode" => "Admin",
            "date" => date("Y-m-d H:i:s"),
            "ip" => GetIP(),
            "extra" => $orderId
        ]);
        $update = $conn->prepare("UPDATE clients SET balance=:balance WHERE client_id=:id");
        $update->execute([
            "id" => $client["client_id"],
            "balance" => $client["balance"] + $amount
        ]);
        $conn->commit();
        success_response_exit("Record added and amount added to balance.");
    }
    if ($action == "deduct") {
        $conn->beginTransaction();
        $insert = $conn->prepare("INSERT INTO payments (client_id, client_balance, payment_amount, payment_method, payment_status, payment_delivery, payment_mode, payment_create_date, payment_ip, payment_extra) VALUES (:cid, :balance, :amount, :method, :status, :delivery, :mode, :date, :ip, :extra)");
        $insert->execute([
            "cid" => $client["client_id"],
            "balance" => $client["balance"],
            "amount" => -$amount,
            "method" => $methodId,
            "status" => 3,
            "delivery" => 2,
            "mode" => "Admin",
            "date" => date("Y-m-d H:i:s"),
            "ip" => GetIP(),
            "extra" => $orderId
        ]);
        $update = $conn->prepare("UPDATE clients SET balance=:balance WHERE client_id=:id");
        $update->execute([
            "id" => $client["client_id"],
            "balance" => $client["balance"] - $amount
        ]);
        $conn->commit();
        success_response_exit("Record added and amount deducted from balance.");
    }

}

require admin_view("fund-add-history");
?>
