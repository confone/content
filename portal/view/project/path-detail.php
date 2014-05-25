<?php
$stylesheets = array('project.css');
$scripts = array('project.js');

include 'view/include/header.php';
include 'view/project/part/group-right.php';

$images = $projectPath->getImages();
$texts = $projectPath->getTexts();
?>
<div class="list_holders" style="min-height:100px;">
<div class="title">
<button class="new_holder_btn round4" onclick="javascript:showHideDiv('new_image')">+ | new image</button>
<a href="javascript:hideShowDiv('image_list')" onclick="javascript:updateExpendLabel('image_exp')">Group Images <span id="image_exp">(-)</span></a>
</div>
<div id="new_image" class="new_holder">
<form action="/image/new" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="text" class="round4 holder_name" name="code" placeholder="(Image Code)" />
<input type="hidden" name="application_id" value="<?=$project->getId() ?>" />
<input type="hidden" name="project_path_id" value="<?=$projectPath->getId() ?>" />
<input type="submit" class="button round4" value="Submit" />
</form>
</div>
<div id="image_list" class="holders">
<?php if (!empty($images)) {
foreach ($images as $image) { ?>
<div class="pdata">
<span class="detail">preview: </span><img src="<?=$base_host ?>/rest/image/display/<?=$image->getId() ?>/<?=$image->getCode() ?>/preview" />
<span class="detail">current: </span><img src="<?=$base_host ?>/rest/image/display/<?=$image->getId() ?>/<?=$image->getCode() ?>" />
<span class="detail">belongs to: <?=$image->countProjectPaths() ?> groups</span>
</div>
<div class="section"><a class="project_link" href="/image/detail?application_id=<?=$project->getId() ?>&id=<?=$image->getId() ?>"><?=$image->getCode(); ?></a>
</div>
<?php } 
} else { ?>
<center><div id="no_project">No image yet, <a id="create_now" href="javascript:showHideDiv('new_image')">create now</a> !</div></center>
<?php } ?>
</div>
</div>
<div class="list_holders" style="min-height:100px;">
<div class="title">
<button class="new_holder_btn round4" onclick="javascript:showHideDiv('new_text')">+ | new text</button>
<a href="javascript:hideShowDiv('text_list')" onclick="javascript:updateExpendLabel('text_exp')">Group Texts <span id="text_exp">(-)</span></a>
</div>
<div id="new_text" class="new_holder">
<form action="/text/new" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="text" class="round4 holder_name" name="code" placeholder="(Text Code)" />
<input type="hidden" name="application_id" value="<?=$project->getId() ?>" />
<input type="hidden" name="project_path_id" value="<?=$projectPath->getId() ?>" />
<input type="submit" class="button round4" value="Submit" />
</form>
</div>
<div id="text_list" class="holders">
<?php if (!empty($texts)) {
foreach ($texts as $text) { ?>
<div class="pdata">
<span class="detail">languages: <?=$text->getLanguageCount() ?></span>
<span class="detail">belongs to: <?=$text->countProjectPaths() ?> groups</span>
</div>
<div class="section"><a class="project_link" href="/text/detail?application_id=<?=$project->getId() ?>&id=<?=$text->getId() ?>"><?=$text->getCode(); ?></a>
</div>
<?php } 
} else { ?>
<center><div id="no_project">No text yet, <a id="create_now" href="javascript:showHideDiv('new_text')">create now</a> !</div></center>
<?php } ?>
</div>
</div>
<?php 
include 'view/include/footer.php';
?>