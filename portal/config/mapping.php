<?php
register('/index', new ContentHomeController());

register('/application/list',      new ProjectListController());
register('/application/detail',    new ProjectDetailController());
register('/application/group',     new PathDetailController());
register('/application/new',       new CreateProjectController());
register('/application/group/new', new CreateProjectPathController());

register('/image/detail',      new ImageDetailController());
register('/image/new',         new CreateImageController());
register('/image/group',       new ImageToPathController());
register('/image/version/new', new CreateImageVersionController());
register('/image/publish',     new PublishImagePreviewController());

register('/text/detail',      new TextDetailController());
register('/text/new',         new CreateTextController());
register('/text/group',       new TextToPathController());
register('/text/version/new', new CreateTextVersionController());
register('/text/publish',     new PublishTextPreviewController());

register('/howto', new ContentHowtoController());
?>
