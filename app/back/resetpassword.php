<?php
if(!defined('BASEPATH')) {
   die('Direct access to the script is not allowed');
}
$title .= $languageArray["resetpassword.title"];

if( $_SESSION["msmbilisim_userlogin"] == 1  || $user["client_type"] == 1 || $settings["resetpass_page"] == 1  ){
  header("Location:".site_url());
  exit;
}

$step = isset($_POST['step']) ? intval($_POST['step']) : 0;
$errorText = '';
$successText = '';

if( $_POST && $step > 0 ):

$captcha = $_POST['g-recaptcha-response'] ?? '';
$googlesecret = $settings["recaptcha_secret"];

if ($settings["recaptcha"] == 2 && !empty($googlesecret)) {
    $captcha_control = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$googlesecret&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
    $captcha_control = json_decode($captcha_control);
    if ($captcha_control->success == false) {
        $errorText = $languageArray["error.resetpassword.recaptcha"] ?? "Please complete the captcha verification.";
    }
}

if (empty($errorText)):

switch($step) {
    case 1:
        $user_input = trim($_POST["user"] ?? '');
        $mode = $_POST["mode"] ?? 'email';
        
        if (empty($user_input)) {
            $errorText = "Please enter your " . ($mode == 'email' ? 'email address' : 'username') . ".";
            break;
        }
        
        if ($mode == 'email') {
            $row = $conn->prepare("SELECT * FROM clients WHERE email=:input");
        } else {
            $row = $conn->prepare("SELECT * FROM clients WHERE username=:input");
        }
        $row->execute(array("input" => $user_input));
        
        if (!$row->rowCount()) {
            $errorText = "We couldn't find an account with that " . ($mode == 'email' ? 'email address' : 'username') . ".";
            break;
        }
        
        $client = $row->fetch(PDO::FETCH_ASSOC);
        
        if (empty($client["email"])) {
            $errorText = "This account doesn't have a registered email address. Please contact support.";
            break;
        }
        
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        
        $update = $conn->prepare("UPDATE clients SET passwordreset_token=:code, passwordreset_expires=:expires WHERE client_id=:id");
        $update->execute(array("id" => $client["client_id"], "code" => $code, "expires" => $expires));
        
        $htmlContent = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
            <h2 style='color: #2F86FA;'>Password Reset Verification</h2>
            <p>Hello,</p>
            <p>You requested a password reset. Use the verification code below:</p>
            <div style='background: #f5f5f5; padding: 20px; text-align: center; margin: 20px 0; border-radius: 8px;'>
                <span style='font-size: 32px; font-weight: bold; letter-spacing: 8px; color: #333;'>{$code}</span>
            </div>
            <p>This code will expire in 10 minutes.</p>
            <p>If you didn't request this, please ignore this email.</p>
            <p style='color: #888; font-size: 12px;'>- " . ($settings["site_name"] ?? 'SMM Panel') . "</p>
        </div>";
        
        $to = $client["email"];
        $subject = "Password Reset Code - " . ($settings["site_name"] ?? 'SMM Panel');
        
        try {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->IsSMTP();
            $mail->CharSet = 'UTF-8';
            
            $smtpHost = $settings["smtp_server"] ?? '';
            $smtpPort = intval($settings["smtp_port"] ?? 587);
            $smtpUser = $settings["smtp_user"] ?? '';
            $smtpPass = $settings["smtp_pass"] ?? '';
            $smtpFrom = $settings["admin_mail"] ?? $smtpUser;
            $smtpFromName = $settings["site_name"] ?? $_SERVER["HTTP_HOST"];
            $smtpProtocol = $settings["smtp_protocol"] ?? 'tls';
            
            if ($smtpProtocol == 'ssl' || $smtpPort == 465) {
                $smtpEncryption = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
            } else {
                $smtpEncryption = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            }
            
            if (empty($smtpHost) || empty($smtpUser) || empty($smtpPass)) {
                $errorText = "Email service is not configured. Please contact support.";
                error_log("Password reset failed: SMTP credentials not configured");
                break;
            }
            
            $mail->Host = $smtpHost;
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            $mail->Port = $smtpPort;
            $mail->SMTPSecure = $smtpEncryption;
            $mail->Username = $smtpUser;
            $mail->Password = $smtpPass;
            $mail->setFrom($smtpFrom, $smtpFromName);
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $htmlContent;
            
            if ($mail->send()) {
                $successText = "We've sent a verification code to your email. Please check your inbox.";
                $_SESSION['reset_user'] = $user_input;
                $_SESSION['reset_step'] = 2;
            } else {
                $errorText = "Failed to send verification email. Please try again.";
                error_log("Password reset email failed: " . $mail->ErrorInfo);
            }
        } catch (Exception $e) {
            $errorText = "Failed to send verification email. Please try again later.";
            error_log("Password reset exception: " . $e->getMessage());
        }
        break;
        
    case 2:
        $user_input = trim($_POST["user"] ?? $_SESSION['reset_user'] ?? '');
        $code = trim($_POST["code"] ?? '');
        
        if (empty($code) || strlen($code) != 6) {
            $errorText = "Please enter the 6-digit verification code.";
            break;
        }
        
        $row = $conn->prepare("SELECT * FROM clients WHERE (email=:input OR username=:input) AND passwordreset_token=:code");
        $row->execute(array("input" => $user_input, "code" => $code));
        
        if (!$row->rowCount()) {
            $errorText = "Invalid verification code. Please check and try again.";
            break;
        }
        
        $client = $row->fetch(PDO::FETCH_ASSOC);
        
        if (!empty($client["passwordreset_expires"])) {
            $expires = strtotime($client["passwordreset_expires"]);
            if (time() > $expires) {
                $errorText = "This verification code has expired. Please request a new one.";
                break;
            }
        }
        
        $successText = "Code verified successfully! Please create your new password.";
        $_SESSION['reset_user'] = $user_input;
        $_SESSION['reset_code'] = $code;
        $_SESSION['reset_step'] = 3;
        break;
        
    case 3:
        $user_input = trim($_POST["user"] ?? $_SESSION['reset_user'] ?? '');
        $code = trim($_POST["code"] ?? $_SESSION['reset_code'] ?? '');
        $password = $_POST["password"] ?? '';
        $password_again = $_POST["password_again"] ?? '';
        
        if (empty($password) || strlen($password) < 6) {
            $errorText = "Password must be at least 6 characters long.";
            break;
        }
        
        if ($password !== $password_again) {
            $errorText = "Passwords do not match. Please try again.";
            break;
        }
        
        $row = $conn->prepare("SELECT * FROM clients WHERE (email=:input OR username=:input) AND passwordreset_token=:code");
        $row->execute(array("input" => $user_input, "code" => $code));
        
        if (!$row->rowCount()) {
            $errorText = "Session expired. Please start the password reset process again.";
            break;
        }
        
        $client = $row->fetch(PDO::FETCH_ASSOC);
        
        $update = $conn->prepare("UPDATE clients SET password=:pass, passwordreset_token='', passwordreset_expires=NULL WHERE client_id=:id");
        $update->execute(array("id" => $client["client_id"], "pass" => md5($password)));
        
        if ($update) {
            $successText = "Password reset successfully! Redirecting to login...";
            unset($_SESSION['reset_user']);
            unset($_SESSION['reset_code']);
            unset($_SESSION['reset_step']);
            echo '<script>setTimeout(function(){ window.location.href="'.site_url().'auth"; }, 2000);</script>';
        } else {
            $errorText = "Failed to update password. Please try again.";
        }
        break;
}

endif;

endif;
