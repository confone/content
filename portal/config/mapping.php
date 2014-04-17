<?php
register('/index', new ContentHomeController());

register('/project/list',     new ProjectListController());
register('/project/detail',   new ProjectDetailController());
register('/project/path',     new PathDetailController());
register('/project/new',      new CreateProjectController());
register('/project/path/new', new CreateProjectPathController());

register('/image/detail',      new ImageDetailController());
register('/image/new',         new CreateImageController());
register('/image/path',        new ImageToPathController());
register('/image/version/new', new CreateImageVersionController());

register('/text/detail',      new TextDetailController());
register('/text/new',         new CreateTextController());
register('/text/path',        new TextToPathController());
register('/tect/version/new', new CreateTextVersionController());

register('/howto', new ContentHowtoController());
?>
