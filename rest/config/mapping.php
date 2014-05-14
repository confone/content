<?php
register('GET',  '/image/code/:code',             new ImageCodeGetHandler(), null);
register('GET',  '/image/group/:pathname/images', new ImagePathGetHandler(), null);
//register('POST', '/image',                        new ImageCreateHandler(),  new ImageCreateValidator());
//register('POST', '/image/:imageid/publish',       new ImagePublishHandler(), new ImagePublishValidator());
//register('PUT',  '/image/:imageid/upload',        new ImageUpdateHandler(),  new ImageUpdateValidator());

register('POST', '/application',                          new ProjectCreateHandler(),          new ProjectCreateValidator());
register('POST', '/application/:projectid/group',         new ProjectPathCreateHandler(),      new ProjectPathCreateValidator());
register('GET',  '/application/:projectid/gropu/:pathid', new ProjectPathChildrenGetHandler(), null);

register('GET',  '/text/code/:code',            new TextCodeGetHandler(), null);
register('GET',  '/text/group/:pathname/texts', new TextPathGetHandler(), null);
//register('POST', '/text',                       new TextCreateHandler(),  new TextCreateValidator());
//register('POST', '/text/:textid/publish',       new TextPublishHandler(), new TextPublishValidator());
//register('PUT',  '/text/:textid/upload',        new TextUpdateHandler(),  new TextUpdateValidator());

// ============================================================================================== display

register('GET',  '/image/display/:imageid/:code',                  new ImageDisplayHandler(), null);
register('GET',  '/image/display/:imageid/:code/preview',          new ImagePreviewHandler(), null);
register('GET',  '/image/display/:imageid/:code/version/:version', new ImageVersionHandler(), null);
?>
