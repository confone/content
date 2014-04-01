<?php
include '../config/config.inc';
$session = CSession::instance();
if (!$session->get(CSession::$AUTHINDEX)) {
    header('Location: ../auth/login.php');
    exit;
}
?>
<?php include '../inc/header.php'?>
<?php include '../inc/footer.php'?>