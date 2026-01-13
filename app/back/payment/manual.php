<?php
if (!defined('PAYMENT')) {
    http_response_code(404);
    die();
}

$bankName = $methodExtras["bank_name"] ?? '';
$accountNumber = $methodExtras["account_number"] ?? '';
$accountHolder = $methodExtras["account_holder"] ?? '';
$instructions = $methodExtras["instructions"] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $paymentAmount = floatval($_POST["paymentAmount"]);
    $transactionRef = trim($_POST["transaction_ref"] ?? '');
    $paymentNote = trim($_POST["payment_note"] ?? '');
    
    if ($paymentAmount < $methodMin || $paymentAmount > $methodMax) {
        errorExit("Amount must be between " . $methodCurrencySymbol . $methodMin . " and " . $methodCurrencySymbol . $methodMax);
    }
    
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
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode($response, true);
    exit;
}

?>
<div class="payment-method-form">
    <h4><?php echo $methodVisibleName; ?></h4>
    
    <?php if (!empty($instructions)): ?>
    <div class="alert alert-info">
        <strong>Instructions:</strong><br>
        <?php echo nl2br(htmlspecialchars($instructions)); ?>
    </div>
    <?php endif; ?>
    
    <?php if (!empty($bankName) || !empty($accountNumber) || !empty($accountHolder)): ?>
    <div class="bank-details mb-3">
        <h5>Bank Details</h5>
        <table class="table table-bordered">
            <?php if (!empty($bankName)): ?>
            <tr><td><strong>Bank Name</strong></td><td><?php echo htmlspecialchars($bankName); ?></td></tr>
            <?php endif; ?>
            <?php if (!empty($accountNumber)): ?>
            <tr><td><strong>Account Number</strong></td><td><?php echo htmlspecialchars($accountNumber); ?></td></tr>
            <?php endif; ?>
            <?php if (!empty($accountHolder)): ?>
            <tr><td><strong>Account Holder</strong></td><td><?php echo htmlspecialchars($accountHolder); ?></td></tr>
            <?php endif; ?>
        </table>
    </div>
    <?php endif; ?>
    
    <form method="POST" action="<?php echo site_url('payment/manual'); ?>" id="manualPaymentForm">
        <div class="mb-3">
            <label class="form-label">Amount (<?php echo $methodCurrencySymbol; ?>)</label>
            <input type="number" name="paymentAmount" class="form-control" 
                   min="<?php echo $methodMin; ?>" max="<?php echo $methodMax; ?>" 
                   step="0.01" required placeholder="Enter amount">
            <small class="text-muted">Min: <?php echo $methodCurrencySymbol . $methodMin; ?> - Max: <?php echo $methodCurrencySymbol . $methodMax; ?></small>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Transaction Reference / Receipt Number *</label>
            <input type="text" name="transaction_ref" class="form-control" required 
                   placeholder="Enter your transaction reference or receipt number">
        </div>
        
        <div class="mb-3">
            <label class="form-label">Additional Notes (Optional)</label>
            <textarea name="payment_note" class="form-control" rows="3" 
                      placeholder="Any additional information about your payment"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Submit Payment Request</button>
    </form>
</div>

<script>
document.getElementById('manualPaymentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var form = this;
    var formData = new FormData(form);
    
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location.reload();
        } else {
            alert(data.message || 'An error occurred');
        }
    })
    .catch(error => {
        alert('An error occurred. Please try again.');
    });
});
</script>
