<?php
include '../config/config.inc';

$session = CSession::instance();

$session->logout();

header('Location: ../admin/');
?>