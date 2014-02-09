<?php
include '../config/config.inc';
include '../inc/recaptchalib.php';
$session = CSession::instance();
if ($session->get(CSession::$AUTHINDEX)) {
    header('Location: ../admin/welcome.php');
}
?>
<?php include '../inc/header.php'?>
<div class='signin'>
<?php if (isset($error)) { echo '<label class="error">- '.$error.'</label>'; }?>
    <form class="pure-form" method="post" action="" enctype="multipart/form-data" accept-charset="UTF-8">
        <fieldset class="pure-group">
            <input type="text" class="pure-input-1" placeholder="Email" name="confone_admin_username">
            <input type="text" class="pure-input-1" placeholder="Name" name="confone_admin_name">
            <input type="password" class="pure-input-1" placeholder="Password" name="confone_admin_password">
            <input type="password" class="pure-input-1" placeholder="Confirm Password" name="confone_admin_password2">
        </fieldset>
<?php
    $publickey = '6LeG0u0SAAAAAAv3uvryrtuQO--Wyy5a8iKwa9Zl';
    echo recaptcha_get_html($publickey);
?>
        <div class="separator"></div>
        <button type="submit" class="pure-button pure-input-1 pure-button-primary">Sign in</button>
	</form>
</div>

<?php include '../inc/footer.php'?>