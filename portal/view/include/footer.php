</div>
<div id="footer">
</div>
<?php if (isset($scripts)) {
    foreach ($scripts as $script) {
        echo '<script src="/portal/js/'.$script.'"></script>';
    }
} ?>
</body>
</html>