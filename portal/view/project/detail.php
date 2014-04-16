<?php
$stylesheets = array('project.css');
$scripts = array('project.js');

include 'view/include/header.php';
?>
<form action="" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="text" name="project_path" placeholder="(Project Path)" />
<input type="submit" class="button" value="Submit" />
</form>
<?php foreach ($project->getRootPath()->getSubProjectPaths() as $path) { ?>
<div><?=$path->getPathFull(); ?></div>
<?php } ?>
<?php foreach ($project->getRootPath()->getImages() as $image) { ?>
<div><?=$image->getFilePath(); ?></div>
<?php } ?>
<?php foreach ($project->getRootPath()->getTexts() as $text) { ?>
<div><?=$text->getContent(); ?></div>
<?php } ?>
<?php 
include 'view/include/footer.php';
?>