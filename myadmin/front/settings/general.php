<link rel="stylesheet" href="<?=site_url('css/admin/settings-premium.css')?>">

<div class="settings-premium-container">
  <div class="panel panel-default">
    <div class="panel-body">
    
      <!-- Page Header -->
      <div class="settings-page-header">
        <h2><i class="fa fa-cog"></i> General Settings</h2>
        <p>Configure your panel's core settings, branding, and features</p>
      </div>
      
      <!-- Success/Error Alerts -->
      <?php if (isset($success) && $success == 1): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check-circle"></i> <?= isset($successText) ? $successText : 'Settings updated successfully' ?>
        </div>
      <?php endif; ?>
      
      <?php if (isset($error) && $error == 1): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-exclamation-circle"></i> <?= isset($errorText) ? $errorText : 'Failed to update settings' ?>
        </div>
      <?php endif; ?>
    
      <form action="<?=site_url('admin/settings/general')?>" method="post" enctype="multipart/form-data" id="generalSettingsForm">

        <!-- Branding Section -->
        <div class="settings-section">
          <div class="settings-section-header">
            <div class="settings-section-icon">
              <i class="fa fa-paint-brush"></i>
            </div>
            <div class="settings-section-title">
              <h3>Branding</h3>
              <p>Customize your panel's logo, favicon, and name</p>
            </div>
          </div>
          <div class="settings-section-body">
            <!-- Panel Name -->
            <div class="form-group">
              <label class="control-label">Panel Name</label>
              <input type="text" class="form-control" name="name" value="<?=$settings["site_name"]?>" placeholder="Enter your panel name">
            </div>
            
            <div class="settings-divider"></div>
            
            <!-- Logo Upload -->
            <div class="form-group">
              <label class="control-label">Site Logo</label>
              <div class="settings-file-upload">
                <div class="settings-file-dropzone" onclick="document.getElementById('logoInput').click()">
                  <i class="fa fa-cloud-upload"></i>
                  <span>Click to upload logo</span>
                  <input type="file" name="logo" id="logoInput" accept="image/*">
                </div>
                <?php if($settings["site_logo"]): ?>
                  <div class="settings-file-preview">
                    <img src="<?=$settings["site_logo"]?>" alt="Logo">
                    <a href="" class="remove-btn" data-toggle="modal" data-target="#confirmChange" data-href="<?=site_url("admin/settings/general/delete-logo")?>">
                      <i class="fa fa-times"></i>
                    </a>
                  </div>
                <?php endif; ?>
              </div>
            </div>
            
            <!-- Favicon Upload -->
            <div class="form-group">
              <label class="control-label">Site Favicon</label>
              <div class="settings-file-upload">
                <div class="settings-file-dropzone" onclick="document.getElementById('faviconInput').click()">
                  <i class="fa fa-cloud-upload"></i>
                  <span>Click to upload favicon</span>
                  <input type="file" name="favicon" id="faviconInput" accept="image/*">
                </div>
                <?php if($settings["favicon"]): ?>
                  <div class="settings-file-preview">
                    <img src="<?=$settings["favicon"]?>" alt="Favicon">
                    <a href="" class="remove-btn" data-toggle="modal" data-target="#confirmChange" data-href="<?=site_url("admin/settings/general/delete-favicon")?>">
                      <i class="fa fa-times"></i>
                    </a>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>

        <!-- Site Settings Section -->
        <div class="settings-section">
          <div class="settings-section-header">
            <div class="settings-section-icon">
              <i class="fa fa-sliders"></i>
            </div>
            <div class="settings-section-title">
              <h3>Site Settings</h3>
              <p>Control maintenance mode and service visibility</p>
            </div>
          </div>
          <div class="settings-section-body">
            <div class="settings-row settings-row-2">
              <div class="form-group">
                <label class="control-label">Maintenance Mode</label>
                <select class="form-control" name="site_maintenance">
                  <option value="2" <?= $settings["site_maintenance"] == 2 ? "selected" : null; ?>>Inactive</option>
                  <option value="1" <?= $settings["site_maintenance"] == 1 ? "selected" : null; ?>>Active</option>
                </select>
              </div>
              
              <div class="form-group">
                <?php 
                if($settings["service_list"] == "2"){
                    $servlist_active = "selected";
                }else {
                    $servlist_passive = "selected";
                } ?>
                <label class="control-label">Service List Visibility</label>
                <select class="form-control" name="service_list">
                  <option value="2" <?= $servlist_active ?>>Active for everyone</option>
                  <option value="1" <?= $servlist_passive ?>>Active for only users</option>
                </select>
              </div>
            </div>
            
            <div class="form-group">
              <?php 
              if($settings["services_average_time"] == "1"){
                  $avg_time_active = "selected";
              }else {
                  $avg_time_passive = "selected";
              } ?>
              <label class="control-label">Show Average Time</label>
              <select class="form-control" name="services_average_time">
                <option value="1" <?= $avg_time_active ?>>Enabled</option>
                <option value="0" <?= $avg_time_passive ?>>Disabled</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Membership Tiers Section -->
        <div class="settings-section">
          <div class="settings-section-header">
            <div class="settings-section-icon">
              <i class="fa fa-trophy"></i>
            </div>
            <div class="settings-section-title">
              <h3>Membership Tiers</h3>
              <p>Set spending thresholds for tier upgrades: NEW → PREMIUM → RESELLER</p>
            </div>
          </div>
          <div class="settings-section-body">
            <div class="settings-row settings-row-3">
              <div class="form-group">
                <label class="control-label"><i class="fa fa-user" style="color: #2F86FA;"></i> NEW (Default)</label>
                <input type="text" class="form-control" value="0" disabled placeholder="Default tier for all users">
                <small class="text-muted">All new users start here</small>
              </div>
              
              <div class="form-group">
                <label class="control-label"><i class="fa fa-crown" style="color: #7c3aed;"></i> PREMIUM Threshold</label>
                <input type="text" class="form-control" name="bronz_statu" value="<?=$settings["bronz_statu"]?>" placeholder="e.g. 5000">
                <small class="text-muted">5-15% discounts, priority support</small>
              </div>
              
              <div class="form-group">
                <label class="control-label"><i class="fa fa-rocket" style="color: #f59e0b;"></i> RESELLER Threshold</label>
                <input type="text" class="form-control" name="bayi_statu" value="<?=$settings["bayi_statu"]?>" placeholder="e.g. 25000">
                <small class="text-muted">15% discount, own website access</small>
              </div>
            </div>
            <!-- Hidden fields to maintain database compatibility -->
            <input type="hidden" name="silver_statu" value="<?=$settings["silver_statu"]?>">
            <input type="hidden" name="gold_statu" value="<?=$settings["gold_statu"]?>">
            
            <div class="settings-info-box">
              <i class="fa fa-info-circle"></i>
              <span>Users automatically upgrade tiers based on total spending. RESELLER unlocks 15% discount and ability to get their own website.</span>
            </div>
          </div>
        </div>

        <!-- Security Settings Section -->
        <div class="settings-section">
          <div class="settings-section-header">
            <div class="settings-section-icon">
              <i class="fa fa-shield"></i>
            </div>
            <div class="settings-section-title">
              <h3>Security Settings</h3>
              <p>Configure password reset and authentication options</p>
            </div>
          </div>
          <div class="settings-section-body">
            <div class="settings-row settings-row-3">
              <div class="form-group">
                <?php 
                if($settings["resetpass_page"] == "2"){
                    $respass_active = "selected";
                }else{
                    $respass_passive = "selected";
                } ?>
                <label class="control-label">Reset Password</label>
                <select class="form-control" name="resetpass">
                  <option value="2" <?= $respass_active ?>>Enabled</option>
                  <option value="1" <?= $respass_passive ?>>Disabled</option>
                </select>
              </div>
              
              <div class="form-group">
                <?php 
                if($settings["resetpass_sms"] == "2"){
                    $ressms_active = "selected";
                }else{
                    $ressms_passive = "selected";
                } ?>
                <label class="control-label">Reset via SMS</label>
                <select class="form-control" name="resetsms">
                  <option value="2" <?= $ressms_active ?>>Enabled</option>
                  <option value="1" <?= $ressms_passive ?>>Disabled</option>
                </select>
              </div>
              
              <div class="form-group">
                <?php 
                if($settings["resetpass_email"] == "2"){
                    $resemail_active = "selected";
                }else{
                    $resemail_passive = "selected";
                } ?>
                <label class="control-label">Reset via Email</label>
                <select class="form-control" name="resetmail">
                  <option value="2" <?= $resemail_active ?>>Enabled</option>
                  <option value="1" <?= $resemail_passive ?>>Disabled</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <!-- Ticket System Section -->
        <div class="settings-section">
          <div class="settings-section-header">
            <div class="settings-section-icon">
              <i class="fa fa-ticket"></i>
            </div>
            <div class="settings-section-title">
              <h3>Ticket System</h3>
              <p>Configure customer support ticket settings</p>
            </div>
          </div>
          <div class="settings-section-body">
            <div class="settings-row settings-row-2">
              <div class="form-group">
                <?php 
                if($settings["ticket_system"] == "1"){
                    $ticket_active = "selected";
                }else{
                    $ticket_passive = "selected";
                } ?>
                <label class="control-label">Ticket System</label>
                <select class="form-control" name="ticket_system">
                  <option value="1" <?= $ticket_active ?>>Enabled</option>
                  <option value="2" <?= $ticket_passive ?>>Disabled</option>
                </select>
              </div>
              
              <div class="form-group">
                <label class="control-label">Max Pending Tickets per User</label>
                <select class="form-control" name="tickets_per_user">
                  <?php for($i = 1; $i <= 10; $i++): ?>
                    <option value="<?= $i ?>" <?= $settings["tickets_per_user"] == $i ? "selected" : null; ?>><?= $i ?></option>
                  <?php endfor; ?>
                  <option value="9999999999" <?= $settings["tickets_per_user"] == 9999999999 ? "selected" : null; ?>>Unlimited</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <!-- Registration Settings Section -->
        <div class="settings-section">
          <div class="settings-section-header">
            <div class="settings-section-icon">
              <i class="fa fa-user-plus"></i>
            </div>
            <div class="settings-section-title">
              <h3>Registration Settings</h3>
              <p>Configure signup page options and form fields</p>
            </div>
          </div>
          <div class="settings-section-body">
            <div class="settings-row settings-row-2">
              <div class="form-group">
                <?php 
                if($settings["register_page"] == "2"){
                    $reg_active = "selected";
                }else{
                    $reg_passive = "selected";
                } ?>
                <label class="control-label">Signup Page</label>
                <select class="form-control" name="registration_page">
                  <option value="2" <?= $reg_active ?>>Enabled</option>
                  <option value="1" <?= $reg_passive ?>>Disabled</option>
                </select>
              </div>
              
              <div class="form-group">
                <label class="control-label">Email Confirmation</label>
                <select class="form-control" name="email_confirmation">
                  <option value="1" <?= $settings["email_confirmation"] == 1 ? "selected" : null; ?>>Enabled</option>
                  <option value="2" <?= $settings["email_confirmation"] == 2 ? "selected" : null; ?>>Disabled</option>
                </select>
              </div>
            </div>
            
            <div class="settings-row settings-row-2">
              <div class="form-group">
                <label class="control-label">Name Fields</label>
                <select class="form-control" name="name_fileds">
                  <option value="1" <?= $settings["name_fileds"] == 1 ? "selected" : null; ?>>Enabled</option>
                  <option value="2" <?= $settings["name_fileds"] == 2 ? "selected" : null; ?>>Disabled</option>
                </select>
              </div>
              
              <div class="form-group">
                <label class="control-label">Skype Fields</label>
                <select class="form-control" name="skype_feilds">
                  <option value="1" <?= $settings["skype_feilds"] == 1 ? "selected" : null; ?>>Enabled</option>
                  <option value="2" <?= $settings["skype_feilds"] == 2 ? "selected" : null; ?>>Disabled</option>
                </select>
              </div>
            </div>
            
            <div class="settings-row settings-row-2">
              <div class="form-group">
                <label class="control-label">Transfer Funds Fee (%)</label>
                <input type="number" value="<?= $settings["fundstransfer_fees"]; ?>" class="form-control" name="fundstransfer_fees" placeholder="e.g. 5">
              </div>
              
              <div class="form-group">
                <label class="control-label">Resend Link Max</label>
                <input type="text" class="form-control" name="resend_max" value="<?=$settings["resend_max"]?>" placeholder="Recommended: 2">
              </div>
            </div>
          </div>
        </div>

        <!-- Custom Code Section -->
        <div class="settings-section">
          <div class="settings-section-header">
            <div class="settings-section-icon">
              <i class="fa fa-code"></i>
            </div>
            <div class="settings-section-title">
              <h3>Custom Code</h3>
              <p>Add custom CSS or JavaScript to your panel</p>
            </div>
          </div>
          <div class="settings-section-body">
            <div class="form-group">
              <label class="control-label">Header Codes</label>
              <textarea class="form-control" rows="5" name="custom_header" placeholder='<style type="text/css">...</style>'><?=$settings["custom_header"]?></textarea>
              <p class="settings-hint">Add custom CSS styles or meta tags to the header</p>
            </div>
            
            <div class="form-group">
              <label class="control-label">Footer Codes</label>
              <textarea class="form-control" rows="5" name="custom_footer" placeholder='<script>...</script>'><?=$settings["custom_footer"]?></textarea>
              <p class="settings-hint">Add custom JavaScript or tracking scripts to the footer</p>
            </div>
          </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="settings-submit-btn" id="submitBtn">
          <span class="btn-text"><i class="fa fa-save"></i> Save Settings</span>
          <span class="btn-loading">
            <i class="fa fa-spinner fa-spin"></i> Saving...
          </span>
        </button>
        
      </form>
      
      <script>
      document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('generalSettingsForm');
        var submitBtn = document.getElementById('submitBtn');
        
        form.addEventListener('submit', function(e) {
          var panelName = form.querySelector('input[name="name"]');
          if (!panelName || panelName.value.trim() === '') {
            e.preventDefault();
            alert('Panel name cannot be empty');
            panelName.focus();
            return false;
          }
          
          submitBtn.classList.add('loading');
          submitBtn.disabled = true;
        });
        
        // Auto-dismiss alerts
        var alerts = document.querySelectorAll('.alert-dismissible');
        alerts.forEach(function(alert) {
          setTimeout(function() {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(function() {
              alert.remove();
            }, 500);
          }, 5000);
        });
        
        // File upload preview
        document.querySelectorAll('input[type="file"]').forEach(function(input) {
          input.addEventListener('change', function(e) {
            var dropzone = this.closest('.settings-file-dropzone');
            if (this.files && this.files[0]) {
              dropzone.querySelector('span').textContent = this.files[0].name;
            }
          });
        });
        
        // Modal confirmation handler
        $('#confirmChange').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget);
          var href = button.data('href');
          $('#confirmYes').attr('href', href);
        });
      });
      </script>
    </div>
  </div>
</div>

<!-- Confirmation Modal -->
<div class="modal modal-center fade" id="confirmChange" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog modal-dialog-center" role="document">
    <div class="modal-content" style="background: #1a1a2e; border: 1px solid #2a2a4a; border-radius: 12px;">
      <div class="modal-body text-center" style="padding: 30px; color: #fff;">
        <h4 style="margin-bottom: 20px;">Are you sure?</h4>
        <div>
          <a class="btn btn-danger" href="" id="confirmYes" style="margin-right: 10px;">Yes, Delete</a>
          <button type="button" class="btn btn-default" data-dismiss="modal" style="background: #2a2a4a; color: #fff; border: none;">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>
