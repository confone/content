<?php
$stylesheets = array('project.css');
$scripts = array('project.js');

include 'view/include/header.php';
include 'view/include/right-member.php';
$projects = $user->getProjects();
?>
<div>
<div class="list_holders">
<div class="title"><button class="new_holder_btn round4" onclick="javascript:newProject()">+ | new application</button>Your Content Apps</div>
<div id="new_project" class="new_holder">
<form action="/application/new" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="text" class="round4 holder_name" name="project_name" placeholder="(Application Name)" />
<input type="text" class="round4 holder_description" name="project_description" placeholder="(Description)" />
<input type="submit" class="button round4" value="Create" />
</form>
</div>
<div class="holders">
<?php if (!empty($projects)) {
foreach ($projects as $project) { ?>
<div class="pdata">
<span class="detail">groups: <?=$project->getGroupCount() ?></span>
<span class="detail">images: <?=$project->getImageCount() ?></span>
<span class="detail">labels: <?=$project->getTextCount() ?></span>
</div>
<div class="section"><a class="project_link" href="/application/detail?id=<?=$project->getId(); ?>"><?=$project->getName(); ?></a>
<span class="description"><?=$project->getDescription(); ?></span></div>
<?php } 
} else { ?>
<center><div id="no_project">No project yet, <a id="create_now" href="javascript:newProject()">create now</a> !</div></center>
<?php } ?>
</div>
</div>
</div>
<?php 
include 'view/include/footer.php';
?>