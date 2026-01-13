<?php
if (!defined('ADDFUNDS')) {
    http_response_code(404);
    die();
}

$liveSecretKey = $methodExtras["liveSecretKey"] ?? '';

if (empty($liveSecretKey)) {
    errorExit("Khalti payment is not configured properly. Please contact support.");
}

$amountInPaisa = intval($paymentAmount * 100);
$orderId = 'ORDER-' . $user["client_id"] . '-' . time();

$returnUrl = site_url('payment/khalti/callback');
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
        'purchase_order_name' => 'Balance Recharge - ' . $user["username"],
        'customer_info' => [
            'name' => $user["name"] ?? $user["username"],
            'email' => $user["email"] ?? '',
            'phone' => $user["telephone"] ?? ''
        ]
    ]),
    CURLOPT_HTTPHEADER => array(
        'Authorization: key ' . $liveSecretKey,
        'Content-Type: application/json',
    ),
));

$apiResponse = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

$result = json_decode($apiResponse, true);

if ($httpCode == 200 && isset($result['payment_url'])) {
    $response = [];
    $response["success"] = true;
    $response["redirect"] = $result['payment_url'];
} else {
    $errorMessage = $result['detail'] ?? $result['error_key'] ?? 'Failed to initiate payment';
    errorExit("Khalti Error: " . $errorMessage);
}
