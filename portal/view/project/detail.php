<?php
$stylesheets = array('project.css');
$scripts = array('project.js');

include 'view/include/header.php';
include 'view/project/part/detail-right.php';

$groups = $project->getRootPath()->getSubProjectPaths();
$images = $project->getRootPath()->getImages();
$texts = $project->getRootPath()->getTexts();

global $base_host;
?>
<div class="list_holders" style="min-height:100px;">
<div class="title">
<button class="new_holder_btn round4" onclick="javascript:showHideDiv('new_path')">+ | new group</button>
<a href="javascript:hideShowDiv('group_list')" onclick="javascript:updateExpendLabel('group_exp')">App Groups <span id="group_exp">(-)</span></a>
</div>
<div id="new_path" class="new_holder">
<form action="/application/group/new" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="text" class="round4 holder_name" name="project_path" placeholder="(Group Name)" />
<input type="hidden" name="parent_path_id" value="0" />
<input type="hidden" name="application_id" value="<?=$project->getId() ?>" />
<input type="submit" class="button round4" value="Submit" />
</form>
</div>
<div id="group_list" class="holders">
<?php if (!empty($groups)) {
foreach ($groups as $group) { ?>
<div class="pdata">
<span class="detail">images: <?=$group->getImageCount() ?></span>
<span class="detail">texts: <?=$group->getTextCount() ?></span>
</div>
<div class="section"><a class="project_link" href="/application/group?application_id=<?=$project->getId() ?>&id=<?=$group->getId() ?>"><?=$group->getPath(); ?></a>
</div>
<?php } 
} else { ?>
<center><div id="no_project">No project yet, <a id="create_now" href="javascript:showHideDiv('new_path')">create now</a> !</div></center>
<?php } ?>
</div>
</div>
<div class="list_holders" style="min-height:100px;">
<div class="title">
<button class="new_holder_btn round4" onclick="javascript:showHideDiv('new_image')">+ | new image</button>
<a href="javascript:hideShowDiv('image_list')" onclick="javascript:updateExpendLabel('image_exp')">App Images <span id="image_exp">(-)</span></a>
</div>
<div id="new_image" class="new_holder">
<form action="/image/new" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="text" class="round4 holder_name" name="code" placeholder="(Image Code)" />
<input type="hidden" name="application_id" value="<?=$project->getId() ?>" />
<input type="submit" class="button round4" value="Submit" />
</form>
</div>
<div id="image_list" class="holders">
<?php foreach ($images as $image) { ?>
<div class="pdata">
<span class="detail">preview: </span><img src="<?=$base_host ?>/rest/image/display/<?=$image->getId() ?>/<?=$image->getCode() ?>/preview" />
<span class="detail">current: </span><img src="<?=$base_host ?>/rest/image/display/<?=$image->getId() ?>/<?=$image->getCode() ?>" />
<span class="detail">belongs to: <?=$image->countProjectPaths() ?> groups</span>
</div>
<div class="section"><a class="project_link" href="/image/detail?application_id=<?=$project->getId() ?>&id=<?=$image->getId() ?>"><?=$image->getCode(); ?></a>
</div>
<?php } ?>
</div>
</div>
<div class="list_holders" style="min-height:100px;">
<div class="title">
<button class="new_holder_btn round4" onclick="javascript:showHideDiv('new_text')">+ | new text</button>
<a href="javascript:hideShowDiv('text_list')" onclick="javascript:updateExpendLabel('text_exp')">App Texts <span id="text_exp">(-)</span></a>
</div>
<div id="new_text" class="new_holder">
<form action="/text/new" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="text" class="round4 holder_name" name="code" placeholder="(Text Code)" />
<input type="hidden" name="application_id" value="<?=$project->getId() ?>" />
<input type="submit" class="button round4" value="Submit" />
</form>
</div>
<div id="text_list" class="holders">
<?php foreach ($texts as $text) { ?>
<div class="pdata">
<span class="detail">languages: <?=$text->getLanguageCount() ?></span>
<span class="detail">belongs to: <?=$text->countProjectPaths() ?> groups</span>
</div>
<div class="section"><a class="project_link" href="/text/detail?application_id=<?=$project->getId() ?>&id=<?=$text->getId() ?>"><?=$text->getCode(); ?></a>
</div>
<?php } ?>
</div>
</div>
<?php 
include 'view/include/footer.php';
?>