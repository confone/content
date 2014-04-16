<?php
$stylesheets = array('project.css');
$scripts = array('project.js');

include 'view/include/header.php';
?>
<?php foreach ($user->getProjects() as $project) { ?>
<div><a href="/project/detail?id=<?=$project->getId(); ?>"><?=$project->getName(); ?></a></div>
<?php } ?>
<?php 
include 'view/include/footer.php';
?>