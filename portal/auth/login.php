<?php
include '../config/config.inc';
include '../inc/recaptchalib.php';

$session = CSession::instance();

if (!$session->exist('login_count')) {
    $session->set('login_count', 0);
}

if (isset($_POST['confone_admin_username'])) {
    if ($session->get('login_count')>=3) {
        $privatekey = "6LeG0u0SAAAAACi_E_foBj9CyhgpptHDzZ0l2GuW";
        $resp = recaptcha_check_answer( $privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"] );
        if (!$resp->is_valid) {
            $error = 'Invalid ReCAPTCHA input, please try again.';
        } else {
            $adminDao = PaymentAdminDao::authenticate( $_POST['confone_admin_username'],
                                                       $_POST['confone_admin_password'] );
            if (isset($adminDao)) {
                $session->set('login_count', 0);
                $session->set(CSession::$AUTHINDEX, $adminDao->var[PaymentAdminDao::IDCOLUMN]);
            } else {
                $error = 'Invalid username/password combination.';
                Logger::warn('Login attemp: '.$_POST['confone_admin_username'].':'.$_POST['confone_admin_password'].' failed!');
            }
        }
    } else {
        $adminDao = PaymentAdminDao::authenticate( $_POST['confone_admin_username'],
                                                   $_POST['confone_admin_password'] );
        if (isset($adminDao)) {
            $session->set('login_count', 0);
            $session->set(CSession::$AUTHINDEX, $adminDao->var[PaymentAdminDao::IDCOLUMN]);
        } else {
            $error = 'Invalid username/password combination.';
            $session->set('login_count', $session->get('login_count')+1);
            Logger::warn('Login attemp: '.$_POST['confone_admin_username'].':'.$_POST['confone_admin_password'].' failed!');
        }
    }
}

if ($session->exist(CSession::$AUTHINDEX)) {
    header('Location: ../admin/welcome.php');
}

$stylesheets = array('admin.css');
?>

<?php include '../include/header.php'?>
<div class='signin'>
<?php if (isset($error)) { echo '<label class="error">- '.$error.'</label>'; }?>
    <form class="pure-form" method="post" action="">
        <fieldset class="pure-group">
            <input type="text" class="pure-input-1" placeholder="Email" name="confone_admin_username">
            <input type="password" class="pure-input-1" placeholder="Password" name="confone_admin_password">
        </fieldset>
<?php if ($session->get('login_count')>=3) {
    $publickey = '6LeG0u0SAAAAAAv3uvryrtuQO--Wyy5a8iKwa9Zl';
    echo recaptcha_get_html($publickey);
} ?>
        <div class="separator"></div>
        <button type="submit" class="pure-button pure-input-1 pure-button-primary">Sign in</button>
	</form>
</div>

<?php include '../include/footer.php'?>
