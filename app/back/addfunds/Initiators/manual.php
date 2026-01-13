<?php
if (!defined('ADDFUNDS')) {
    http_response_code(404);
    die();
}

$bankName = $methodExtras["bank_name"] ?? '';
$accountNumber = $methodExtras["account_number"] ?? '';
$accountHolder = $methodExtras["account_holder"] ?? '';
$instructions = $methodExtras["instructions"] ?? '';

$transactionRef = trim($_POST["transaction_ref"] ?? '');
$paymentNote = trim($_POST["payment_note"] ?? '');

if (empty($transactionRef)) {
    errorExit("Please enter a transaction reference number.");
}

$insert = $conn->prepare("INSERT INTO payments (client_id, payment_amount, payment_method, payment_mode, payment_create_date, payment_ip, payment_extra, payment_status, payment_delivery, client_balance) VALUES (:client_id, :amount, :method, :mode, :date, :ip, :extra, :status, :delivery, :balance)");
$insert->execute([
    "client_id" => $user["client_id"],
    "amount" => $paymentAmount,
    "method" => $methodId,
    "mode" => "Manual",
    "date" => date("Y.m.d H:i:s"),
    "ip" => GetIP(),
    "extra" => json_encode([
        "transaction_ref" => $transactionRef,
        "payment_note" => $paymentNote
    ]),
    "status" => 1,
    "delivery" => 1,
    "balance" => $user["balance"]
]);

$response = [];
$response["success"] = true;
$response["message"] = "Payment request submitted! Your payment of " . $methodCurrencySymbol . number_format($paymentAmount, 2) . " is pending admin approval.";
