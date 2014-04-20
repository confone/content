<?php
$stylesheets = array('text.css');
$scripts = array('text.js');

include 'view/include/header.php';
?>
<div class="add_version">
<form action="/text/version/new" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="text" name="content" placeholder="(Text Content)" />
<input type="hidden" name="text_id" value="<?=$text->getId() ?>" />
<input type="hidden" name="project_id" value="<?=$text->getProjectId() ?>" />
<input type="submit" class="button" value="Submit" />
</form>
</div>
Versions:
<?php foreach ($text->getAllVersionContent() as $key=>$version) { ?>
<div>Version <?=$key ?>: <?=$version['content'] ?></div>
<?php } ?>
<?php 
include 'view/include/footer.php';
?>