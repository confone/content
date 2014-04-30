<?php 
global $base_host; 
?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=isset($title) ? $title : '' ?></title>
<link rel="shortcut icon" href="/portal/img/favicon.ico" type="image/x-icon">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script src="/portal/js/common.js"></script>

<link rel="stylesheet" href="/portal/css/common.css">
<?php if (isset($stylesheets)) {
    foreach ($stylesheets as $stylesheet) {
        echo '<link rel="stylesheet" href="/portal/css/'.$stylesheet.'">';
    }
} ?>
</head>
<body>
<div id="header">
<div id="header_inner">
<a id="logo" href="<?php global $www_url; echo $www_url; ?>">con<span>fone</span></a>
</div>
</div>
<div id="main">