<?php
$stylesheets = array('project.css');
$scripts = array('project.js');

include 'view/include/header.php';
$projects = $user->getProjects();
?>
<div id="new_project">
<form action="/project/new" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="text" name="project_name" placeholder="(Project Name)" />
<input type="text" name="project_description" placeholder="(Description)" />
<input type="submit" class="button round4" value="Create" />
</form>
</div>
<div>
<div id="member" class="round4">
<div class="title"><label>Owner</label></div>
<img class="profile" src="<?=$user->getProfileImage() ?>" />
<label id="name"><?=$user->getName() ?></label>
</div>
<div id="list_porject">
<div class="title"><button id="new_proj_btn" class="round4">+ | new project</button>List of Project</div>
<div class="projects">
<?php if (!empty($projects)) {
foreach ($projects as $project) { ?>
<div><a class="project_link" href="/project/detail?id=<?=$project->getId(); ?>"><?=$project->getName(); ?></a>
<span><?=$project->getDescription(); ?></span></div>
<?php } 
} else { ?>
<div style="color:#cdcdcd">(empty)</div>
<?php } ?>
</div>
</div>
</div>
<?php 
include 'view/include/footer.php';
?>