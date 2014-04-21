<?php
$stylesheets = array('image.css');
$scripts = array('image.js');

include 'view/include/header.php';
?>
<div class="add_version">
<form action="/image/version/new" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="text" name="path" placeholder="(Image File Path)" />
<input type="hidden" name="image_id" value="<?=$image->getId() ?>" />
<input type="hidden" name="project_id" value="<?=$image->getProjectId() ?>" />
<input type="submit" class="button" value="Submit" />
</form>
</div>
Versions:
<?php foreach ($image->getAllVersionFiles() as $key=>$version) { ?>
<div>Version <?=$key ?>: <?=$version['file_path'] ?></div>
<?php } ?>
<div class="publish">
<form action="/image/publish" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="hidden" name="image_id" value="<?=$image->getId() ?>" />
<input type="hidden" name="project_id" value="<?=$image->getProjectId() ?>" />
<input type="submit" class="button" value="Publish" />
</form>
</div>
<?php 
include 'view/include/footer.php';
?>