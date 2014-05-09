<?php
$stylesheets = array('project.css');
$scripts = array('project.js');

include 'view/include/header.php';
include 'view/include/right-member.php';
$projects = $user->getProjects();
?>
<div>
<div id="list_porject">
<div class="title"><button id="new_proj_btn" class="round4" onclick="javascript:newProject()">+ | new application</button>Your Content Management Apps</div>
<div id="new_project">
<form action="/application/new" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="text" class="round4" id="project_name" name="project_name" placeholder="(Application Name)" />
<input type="text" class="round4" id="project_description" name="project_description" placeholder="(Description)" />
<input type="submit" class="button round4" value="Create" />
</form>
</div>
<div class="projects">
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