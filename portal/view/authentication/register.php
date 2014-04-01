<?php
include '../config/config.inc';
include '../inc/recaptchalib.php';
$session = CSession::instance();
if ($session->get(CSession::$AUTHINDEX)) {
    header('Location: ../admin/welcome.php');
}

if (isset($_POST['confone_admin_email'])) {
    $privatekey = "6LeG0u0SAAAAACi_E_foBj9CyhgpptHDzZ0l2GuW";
    $resp = recaptcha_check_answer( $privatekey,
                                    $_SERVER["REMOTE_ADDR"],
                                    $_POST["recaptcha_challenge_field"],
                                    $_POST["recaptcha_response_field"] );
    if (!$resp->is_valid) {
        $error = 'Invalid ReCAPTCHA input, please try again.';
    } else if ($_POST['confone_admin_password']!=$_POST['confone_admin_password2']) {
       	$error = 'Password and Confirm Password do NOT match.';
    } else {
    	$account = new AccountDao();
    	$account->var[AccountDao::EMAIL] = $_POST['confone_admin_email'];
    	$account->var[AccountDao::PASSWORD] = md5($_POST['confone_admin_password']);
    	$account->var[AccountDao::NAME] = $_POST['confone_admin_name'];

    	if ($account->save()) {
    		$token = new AccountTokenDao();
    		$token->var[AccountTokenDao::ACCOUNTID] = $account->var[AccountDao::IDCOLUMN];
    		$token->var[AccountTokenDao::TYPE] = AccountTokenDao::TYPE_ACTIVATION;
    		$token->save();

			EmailUtil::sendActivationEmail( $account->var[AccountDao::EMAIL], 
    										$account->var[AccountDao::NAME], 
    										$token );

			$msg = 'Thank you for register with Confone. An activation email has been sent to your account.<br>'.
					'If you have not received it, please <a href="javascript:sendActivationEmail(\''.$account->var[AccountDao::EMAIL].'\', '.$account->var[AccountDao::IDCOLUMN].')">click here</a> to send it again.';
    	} else {
    		$error = 'Invalid ReCAPTCHA input, please try again.';
    	}
    }
}

$scripts = array('auth.js');
?>
<?php include '../inc/header.php'?>
<div class='signin'>
<?php if (isset($error)) { echo '<label class="error">x '.$error.'</label>'; }?>
<?php if (isset($msg)) { echo '<label id="msg" class="msg">'.$msg.'</label>'; }?>
    <form class="pure-form" method="post" action="" enctype="multipart/form-data" accept-charset="UTF-8">
        <input type="text" class="pure-input-1" placeholder="Email" name="confone_admin_email">
        <input type="text" class="pure-input-1" placeholder="Name" name="confone_admin_name">
        <input type="password" class="pure-input-1" placeholder="Password" name="confone_admin_password">
        <input type="password" class="pure-input-1" placeholder="Confirm Password" name="confone_admin_password2">
<?php if ($session->get('login_count')>=3) {
    $publickey = '6LeG0u0SAAAAAAv3uvryrtuQO--Wyy5a8iKwa9Zl';
    echo recaptcha_get_html($publickey);
} ?>
        <div class="separator"></div>
        <button type="submit" class="pure-button pure-input-1 pure-button-primary">Sign in</button>
	</form>
</div>

<?php include '../inc/footer.php'?>