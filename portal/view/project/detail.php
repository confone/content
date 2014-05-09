<?php
$stylesheets = array('project.css');
$scripts = array('project.js');

include 'view/include/header.php';
include 'view/include/right-member.php';
?>
<div class="new_group">
<form action="/application/group/new" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="text" name="project_path" placeholder="(Project Path)" />
<input type="hidden" name="parent_path_id" value="0" />
<input type="hidden" name="application_id" value="<?=$project->getId() ?>" />
<input type="submit" class="button round4" value="Submit" />
</form>
</div>
<div class="new_image">
<form action="/image/new" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="text" name="code" placeholder="(Image Code)" />
<input type="hidden" name="application_id" value="<?=$project->getId() ?>" />
<input type="submit" class="button round4" value="Submit" />
</form>
</div>
<div class="new_text">
<form action="/text/new" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="text" name="code" placeholder="(Text Code)" />
<input type="hidden" name="application_id" value="<?=$project->getId() ?>" />
<input type="submit" class="button round4" value="Submit" />
</form>
</div>
<div>
Public Key: <?=$project->getPublicKey() ?><br>
Private Key: <?=$project->getPrivateKey() ?>
</div>
<div>
Groups:<br>
<?php foreach ($project->getRootPath()->getSubProjectPaths() as $path) { ?>
<div><a href="/application/group?application_id=<?=$project->getId() ?>&id=<?=$path->getId() ?>"><?=$path->getPath(); ?></a></div>
<?php } ?>
</div>
<div>
Images:<br>
<?php foreach ($project->getRootPath()->getImages() as $image) { ?>
<div><a href="/image/detail?application_id=<?=$project->getId() ?>&id=<?=$image->getId() ?>"><?=$image->getCode(); ?></a></div>
<?php } ?>
</div>
<div>
Texts:<br>
<?php foreach ($project->getRootPath()->getTexts() as $text) { ?>
<div><a href="/text/detail?application_id=<?=$project->getId() ?>&id=<?=$text->getId() ?>"><?=$text->getCode(); ?></a></div>
<?php } ?>
</div>
<?php 
include 'view/include/footer.php';
?>