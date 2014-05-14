<?php
$stylesheets = array('image.css');
$scripts = array('image-detail.js');

include 'view/include/header.php';

global $base_host, $image_separator;

$belongs = $image->getProjectPaths();
$published = $base_host.'/rest/image/display/'.$image->getId().'/'.$image->getCode();
$preview = $base_host.'/rest/image/display/'.$image->getId().'/'.$image->getCode().'/preview';
$versions = $base_host.'/rest/image/display/'.$image->getId().'/'.$image->getCode().'/version/';

$keys = array_keys($image->getAllVersionFiles());
$max = max($keys);
$versionFiles = $image->getAllVersionFiles();
?>
<div>
<table>
<thead>
<tr><td>image</td><td>link</td></tr>
</thead>
<tbody>
<tr><td>current:</td><td class="link"><?=$published ?></td></tr>
<tr><td>preview:</td><td class="link"><?=$preview ?></td></tr>
<tr><td>version:</td><td class="link"><?=$versions ?>{version#}</td></tr>
</tbody>
</table>
</div>
<br>
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
<input type="hidden" id="application_id" name="application_id" value="<?=$image->getProjectId() ?>" />
<input type="submit" class="button" value="Submit" id="submitbutton" />
</form>
</div>
Versions:
<div>
<label><span style="color:#800000">Preview</span>: <img style="vertical-align:middle;max-width:100px;max-height:80px;margin:5px;" src="<?=$preview ?>"/> <?php 
$paths = explode($image_separator, $versionFiles[Image::PREVIEW_VERSION]['file_path']); 
echo $paths[1];
?></label>
</div>
<?php foreach ($versionFiles as $key=>$version) { 
if ($key==Image::PREVIEW_VERSION) { continue; }
if ($key==$max) {
	$label = '<span style="color:#008000">Current</span>';
} else {
	$label = '<span>Version '.$key.'</span>';
}
?>
<div>
<label><?=$label ?>: <img style="vertical-align:middle;max-width:100px;max-height:80px;margin:5px;" src="<?=$versions.$key ?>"/> <?php 
$paths = explode($image_separator, $version['file_path']); 
echo $paths[1];
?></label>
</div>
<?php } ?>
<div class="publish">
<form action="/image/publish" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="hidden" name="image_id" value="<?=$image->getId() ?>" />
<input type="hidden" name="application_id" value="<?=$image->getProjectId() ?>" />
<input type="submit" class="button" value="Publish" />
</form>
<br>
Groups:<br>
<div id="groups">
<?php foreach ($project->getRootPath()->getSubProjectPaths() as $path) { 
$checked = isset($belongs[$path->getId()]) ? 'checked' : '';
?>
<input type="checkbox" id="ch_<?=$path->getId() ?>" onclick="javascript:changeImageGroup(<?=$path->getId() ?>)" <?=$checked ?>/>
<label for="ch_<?=$path->getId() ?>"><?=$path->getPath() ?></label><br>
<?php } ?>
</div>
</div>
<?php 
include 'view/include/footer.php';
?>