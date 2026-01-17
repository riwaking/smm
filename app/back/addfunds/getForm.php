<?php 
if (!defined('ADDFUNDS')) {
    http_response_code(404);
    die();
}

$methodInfo = $conn->prepare("SELECT methodinstructions FROM paymentmethods WHERE methodid = :id");
$methodInfo->execute(["id" => $selectedMethod]);
$methodData = $methodInfo->fetch(PDO::FETCH_ASSOC);
$instructions = '';
if ($methodData && !empty(trim($methodData["methodinstructions"] ?? ''))) {
    $instructionsText = $methodData["methodinstructions"];
    
    // Remove Quill code block wrapper if present
    $instructionsText = preg_replace('/<pre[^>]*class="ql-syntax"[^>]*>(.*?)<\/pre>/s', '$1', $instructionsText);
    
    // Decode HTML entities (multiple times for double-encoding)
    $instructionsText = html_entity_decode($instructionsText, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $instructionsText = html_entity_decode($instructionsText, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    
    // Convert &nbsp; to regular spaces
    $instructionsText = str_replace('&nbsp;', ' ', $instructionsText);
    
    // Clean up excessive whitespace from code formatting
    $instructionsText = preg_replace('/^\s+/m', '', $instructionsText);
    
    $instructions = '<div class="payment-instructions" style="margin-bottom: 20px;">' . $instructionsText . '</div>';
}

$amountField = '<div class="form-group">
<label class="control-label">Amount</label>
<input type="number" id="paymentAmount" class="form-control" name="payment_amount" step="0.01" required />
</div>';
$feeField = '<div id="fee_fields"></div>';
$paymentBtn = '<button type="submit" class="btn btn-block btn-primary">[text]</button>';

$formData .= $instructions;

if($selectedMethod == 1){
    $formData .= $amountField;
    $formData .= '<div class="form-group">
    <label class="control-label">Transaction Reference / Receipt Number</label>
    <input type="text" class="form-control" name="transaction_ref" required placeholder="Enter your transaction reference or receipt number" />
    </div>';
    $formData .= '<div class="form-group">
    <label class="control-label">Additional Notes (Optional)</label>
    <textarea class="form-control" name="payment_note" rows="3" placeholder="Any additional information about your payment"></textarea>
    </div>';
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Submit Payment Request");
}

if($selectedMethod == 20){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Pay with Khalti");
}

if($selectedMethod == 2){
    $formData .= '<div class="form-group">
    <label class="control-label">Order ID</label>
    <input type="text" class="form-control" name="payTMOrderId"  required />
    </div>';
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Verify Transaction");
}
if($selectedMethod == 54){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Initiate Payment");
}

if($selectedMethod == 56){
    $formData .= '<div class="form-group">
    <label class="control-label">Transaction ID</label>
    <input type="text" class="form-control" name="BinanceTransactionId"  required />
    </div>';
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Verify Transaction");
}


if($selectedMethod == 3){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Initiate Payment");
}

if($selectedMethod == 4){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Initiate Payment");
}

if($selectedMethod == 55){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Initiate Payment");
}

if($selectedMethod == 5){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Initiate Payment");
}

if($selectedMethod == 6){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Initiate Payment");
}

if($selectedMethod == 7){
    $formData .= '<div class="form-group">
    <label class="control-label">Transaction ID</label>
    <input type="text" class="form-control" name="PhonePeTransactionId"  required />
    </div>';
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Verify Transaction");
}

if($selectedMethod == 8){
    $formData .= '<div class="form-group">
    <label class="control-label">Transaction ID</label>
    <input type="text" class="form-control" name="EasypaisaTransactionId"  required />
    </div>';
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Verify Transaction");
}

if($selectedMethod == 9){
    $formData .= '<div class="form-group">
    <label class="control-label">Transaction ID</label>
    <input type="text" class="form-control" name="JazzcashTransactionId"  required />
    </div>';
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Verify Transaction");
}

if($selectedMethod == 10){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Initiate Payment");
}


if($selectedMethod == 11){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Initiate Payment");
}

if($selectedMethod == 12){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Initiate Payment");
}

if($selectedMethod == 13){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Initiate Payment");
}

if($selectedMethod == 14 ){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Initiate Payment");
}

if($selectedMethod == 15){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Initiate Payment");
}

if($selectedMethod == 16){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Initiate Payment");
}

if($selectedMethod == 17){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Initiate Payment");
}

if($selectedMethod == 18){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Initiate Payment");
}

if($selectedMethod == 29){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Initiate Payment");
}
?>