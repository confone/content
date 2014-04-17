<?php
$stylesheets = array('project.css');
$scripts = array('project.js');

include 'view/include/header.php';
?>
<div class="new_group">
<form action="/project/path/new" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="text" name="project_path" placeholder="(Project Path)" />
<input type="hidden" name="parent_path_id" value="0" />
<input type="hidden" name="project_id" value="<?=$project->getId() ?>" />
<input type="submit" class="button" value="Submit" />
</form>
</div>
<div class="new_image">
<form action="/image/new" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="text" name="code" placeholder="(Image Code)" />
<input type="hidden" name="project_id" value="<?=$project->getId() ?>" />
<input type="submit" class="button" value="Submit" />
</form>
</div>
<div class="new_text">
<form action="/text/new" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="text" name="code" placeholder="(Text Code)" />
<input type="hidden" name="project_id" value="<?=$project->getId() ?>" />
<input type="submit" class="button" value="Submit" />
</form>
</div>
<div>
Groups:<br>
<?php foreach ($project->getRootPath()->getSubProjectPaths() as $path) { ?>
<div><a href="/project/path-detail?project_id=<?=$project->getId() ?>&id=<?=$path->getId() ?>"><?=$path->getPath(); ?></a></div>
<?php } ?>
</div>
<div>
Images:<br>
<?php foreach ($project->getRootPath()->getImages() as $image) { ?>
<div><?=$image->getFilePath(); ?></div>
<?php } ?>
</div>
<div>
Texts:<br>
<?php foreach ($project->getRootPath()->getTexts() as $text) { ?>
<div><?=$text->getContent(); ?></div>
<?php } ?>
</div>
<?php 
include 'view/include/footer.php';
?>