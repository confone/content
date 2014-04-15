<?php
register('/index', new ContentHomeController());

register('/project/list', new ProjectListController());
register('/project/detail', new ProjectDetailController());
register('/project/path', new PathDetailController());

register('/image/detail', new ImageDetailController());
register('/text/detail', new TextDetailController());

register('/howto', new ContentHowtoController());
?>
