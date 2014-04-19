<?php
$stylesheets = array('project.css');
$scripts = array('project.js');

include 'view/include/header.php';
?>
<div class="add_image">
<form action="/image/new" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="text" name="code" placeholder="(Image Code)" />
<input type="hidden" name="parent_path_id" value="<?=$projectPath->getId() ?>" />
<input type="hidden" name="project_id" value="<?=$projectId ?>" />
<input type="submit" class="button" value="Submit" />
</form>
</div>
<div class="add_text">
<form action="/text/new" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="text" name="code" placeholder="(Text Code)" />
<input type="hidden" name="parent_path_id" value="<?=$projectPath->getId() ?>" />
<input type="hidden" name="project_id" value="<?=$projectId ?>" />
<input type="submit" class="button" value="Submit" />
</form>
</div>
<?php foreach ($projectPath->getImages() as $image) { ?>
<div><?=$image->getFilePath(); ?></div>
<?php } ?>
<?php foreach ($projectPath->getTexts() as $text) { ?>
<div><?=$text->getContent(); ?></div>
<?php } ?>
<?php 
include 'view/include/footer.php';
?>