<?php
$stylesheets = array('image.css');
$scripts = array('image-detail.js');

include 'view/include/header.php';
?>
<div class="add_version">
<form action="/image/version/new" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="300000" />
<div>
Files to upload:
<input type="file" id="fileselect" name="file" />
<div id="filedrag">or drop an image file here</div>
</div>
<!-- input type="text" name="path" placeholder="(Image File Path)" / -->
<input type="hidden" id="image_id" name="image_id" value="<?=$image->getId() ?>" />
<input type="hidden" id="project_id" name="project_id" value="<?=$image->getProjectId() ?>" />
<input type="submit" class="button" value="Submit" id="submitbutton" />
</form>
</div>
Versions:
<?php foreach ($image->getAllVersionFiles() as $key=>$version) { ?>
<div>Version <?=$key ?>: <?php 
global $image_separator; 
$paths = explode($image_separator, $version['file_path']); 
echo $paths[1];
?></div>
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