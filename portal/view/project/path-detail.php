<?php
$stylesheets = array('project.css');
$scripts = array('project.js');

include 'view/include/header.php';
include 'view/include/right-member.php';
?>
<div class="add_image">
<form action="/image/new" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="text" name="code" placeholder="(Image Code)" />
<input type="hidden" name="project_path_id" value="<?=$projectPath->getId() ?>" />
<input type="hidden" name="application_id" value="<?=$projectId ?>" />
<input type="submit" class="button" value="Submit" />
</form>
</div>
<div class="add_text">
<form action="/text/new" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="text" name="code" placeholder="(Text Code)" />
<input type="hidden" name="project_path_id" value="<?=$projectPath->getId() ?>" />
<input type="hidden" name="application_id" value="<?=$projectId ?>" />
<input type="submit" class="button" value="Submit" />
</form>
</div>
Group Name: <?=$projectPath->getPath() ?><br>
Image:
<?php foreach ($projectPath->getImages() as $image) { ?>
<div><a href="/image/detail?application_id=<?=$projectPath->getProjectId() ?>&id=<?=$image->getId() ?>"><?=$image->getCode(); ?></a></div>
<?php } ?>
Text:
<?php foreach ($projectPath->getTexts() as $text) { ?>
<div><a href="/text/detail?application_id=<?=$projectPath->getProjectId() ?>&id=<?=$text->getId() ?>"><?=$text->getCode(); ?></a></div>
<?php } ?>
<?php 
include 'view/include/footer.php';
?>