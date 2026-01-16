<link rel="stylesheet" href="<?=site_url('css/admin/settings-premium.css')?>">

<style>
/* Premium header styling only - scoped to avoid affecting modals */
.payment-methods-header {
  background: var(--settings-bg, #0f0f1a);
  padding: 24px;
  margin: -15px -15px 20px -15px;
  border-bottom: 1px solid var(--settings-card-border, #2a2a4a);
}

.payment-methods-header h2 {
  color: #fff;
  font-size: 24px;
  font-weight: 700;
  margin: 0 0 8px 0;
}

.payment-methods-header h2 i {
  margin-right: 12px;
  color: var(--settings-accent, #2F86FA);
}

.payment-methods-header p {
  color: #a0a0b0;
  font-size: 14px;
  margin: 0;
}

/* Scoped panel styling - only affects direct children of paymentMethods */
#paymentMethods > .panel,
#paymentMethods > .row .panel {
  background: var(--settings-card-bg, #1a1a2e) !important;
  border: 1px solid var(--settings-card-border, #2a2a4a) !important;
  border-radius: 12px !important;
  box-shadow: none !important;
}

#paymentMethods > .panel:hover,
#paymentMethods > .row .panel:hover {
  border-color: var(--settings-accent, #2F86FA) !important;
}

#paymentMethods > .panel > .panel-heading,
#paymentMethods > .row .panel > .panel-heading {
  background: rgba(47, 134, 250, 0.05) !important;
  border-bottom: 1px solid var(--settings-card-border, #2a2a4a) !important;
}

#paymentMethods > .panel > .panel-heading h4,
#paymentMethods > .row .panel > .panel-heading h4,
#paymentMethods .panel-title {
  color: #fff !important;
}

#paymentMethods > .panel > .panel-body,
#paymentMethods > .row .panel > .panel-body {
  background: transparent !important;
}

/* Form controls inside paymentMethods only */
#paymentMethods .form-group > label {
  color: #fff !important;
}

#paymentMethods > .panel .form-control,
#paymentMethods > .row .panel .form-control {
  background: #0f0f1a !important;
  border: 1px solid #3a3a5a !important;
  color: #fff !important;
  border-radius: 8px !important;
}

#paymentMethods > .panel .form-control:focus,
#paymentMethods > .row .panel .form-control:focus {
  border-color: #2F86FA !important;
  box-shadow: 0 0 0 3px rgba(47, 134, 250, 0.15) !important;
}

/* Buttons inside paymentMethods only - not modals */
#paymentMethods > .panel .btn-primary,
#paymentMethods > .row .panel .btn-primary {
  background: linear-gradient(135deg, #2F86FA, #1a6dd8) !important;
  border: none !important;
  border-radius: 8px !important;
}

#paymentMethods > .panel .btn-default,
#paymentMethods > .row .panel .btn-default {
  background: #2a2a4a !important;
  border: 1px solid #3a3a5a !important;
  color: #a0a0b0 !important;
  border-radius: 8px !important;
}

/* Tables inside paymentMethods only */
#paymentMethods > .panel .table,
#paymentMethods > .row .panel .table {
  color: #fff !important;
}

#paymentMethods > .panel .table th,
#paymentMethods > .row .panel .table th {
  color: #a0a0b0 !important;
  border-color: #2a2a4a !important;
  background: rgba(0, 0, 0, 0.2) !important;
}

#paymentMethods > .panel .table td,
#paymentMethods > .row .panel .table td {
  border-color: #2a2a4a !important;
  color: #fff !important;
}

/* Badge styling */
#paymentMethods .label-success,
#paymentMethods .badge-success {
  background: rgba(34, 197, 94, 0.15) !important;
  color: #22c55e !important;
}

#paymentMethods .label-danger,
#paymentMethods .badge-danger {
  background: rgba(239, 68, 68, 0.15) !important;
  color: #ef4444 !important;
}

/* Text colors */
#paymentMethods .text-muted {
  color: #a0a0b0 !important;
}

#paymentMethods a {
  color: #2F86FA;
}

/* Dividers */
#paymentMethods hr {
  border-color: #2a2a4a !important;
}

/* Search box in header */
.payment-search-wrapper {
  max-width: 400px;
  margin-top: 16px;
}

.payment-search-wrapper .input-group {
  background: #0f0f1a;
  border: 1px solid #3a3a5a;
  border-radius: 10px;
  overflow: hidden;
}

.payment-search-wrapper .input-group-text {
  background: transparent !important;
  border: none !important;
  color: #a0a0b0;
}

.payment-search-wrapper .form-control {
  background: transparent !important;
  border: none !important;
  color: #fff !important;
  padding: 12px;
}

.payment-search-wrapper .form-control:focus {
  box-shadow: none !important;
}

.payment-search-wrapper .input-group:focus-within {
  border-color: #2F86FA;
  box-shadow: 0 0 0 3px rgba(47, 134, 250, 0.15);
}

/* Loader styling */
#page-loader {
  padding: 40px 20px;
}

#page-loader .spinner .path {
  stroke: var(--settings-accent, #2F86FA);
}
</style>

<div class="container-fluid margin-top-container" style="background: var(--settings-bg, #0f0f1a); min-height: 100vh;">
    <!-- Premium Header -->
    <div class="payment-methods-header">
      <h2><i class="fa fa-credit-card"></i> Payment Methods</h2>
      <p>Configure payment gateways and manage payment options for your customers</p>
      
      <div class="payment-search-wrapper">
        <div class="input-group">
          <span class="input-group-text bg-transparent"><i class="fa fa-search"></i></span>
          <input type="text" id="payment_methods_search" class="form-control" placeholder="Search payment methods...">
        </div>
      </div>
    </div>
    
    <div class="row">
        <div id="page-loader">
            <center><svg class="spinner large" viewBox="0 0 48 48">
                    <circle class="path" cx="24" cy="24" r="20" fill="none" stroke-width="5"></circle>
                </svg></center>
        </div>
        <div id="paymentMethods" class="page-content col col-lg-12">
        </div>
    </div>
</div>
