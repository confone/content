<?php
$stylesheets = array('text.css');
$scripts = array('text.js');

include 'view/include/header.php';

$belongs = $text->getProjectPaths();
?>
<div class="add_version">
<form action="/text/version/new" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<textarea name="content"></textarea><br>
<input type="text" name="language" placeholder="(Language)" />
<input type="hidden" name="text_id" value="<?=$text->getId() ?>" />
<input type="hidden" name="project_id" value="<?=$text->getProjectId() ?>" />
<input type="submit" class="button" value="Submit" />
</form>
</div>
Code: <?=$text->getCode() ?><br>
<?php foreach ($text->getAllVersionContent() as $lang=>$versions) { ?>
Language <?=$lang ?>:<br>
<?php foreach ($versions as $key=>$version) {?>
<div>Version <?=$key ?>: <?=$version['content'] ?></div>
<?php } ?>
<div class="publish">
<form action="/text/publish" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="hidden" name="text_id" value="<?=$text->getId() ?>" />
<input type="hidden" name="project_id" value="<?=$text->getProjectId() ?>" />
<input type="hidden" name="language" value="<?=$lang ?>" />
<input type="submit" class="button" value="Publish" />
</form>
<?php } ?>
<div id="groups">
<?php foreach ($project->getRootPath()->getSubProjectPaths() as $path) { 
$checked = isset($belongs[$path->getId()]) ? 'checked' : '';
?>
<input type="checkbox" id="ch_<?=$path->getId() ?>" onclick="javascript:changeTextGroup(<?=$path->getId() ?>)" <?=$checked ?>/><?=$path->getPath() ?><br>
<?php } ?>
</div>
</div>
<?php 
include 'view/include/footer.php';
?>