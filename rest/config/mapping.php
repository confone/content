<?php
register('GET',  '/image/code/:code', 						new ImageCodeGetHandler(), null);
register('POST', '/image', 									new ImageCreateHandler(), null);
register('GET',  '/image/display/:imageid', 				new ImageDisplayHandler(), null);
register('GET',  '/image/project/:projectid/path/:pathid', 	new ImagePathGetHandler(), null);
register('POST', '/image/:imageid/publish', 				new ImagePublishHandler(), null);
register('PUT',  '/image/:imageid/upload', 					new ImageUpdateHandler(), null);

register('POST', '/project', 						 new ProjectCreateHandler(), null);
register('POST', '/project/:projectid/path', 		 new ProjectPathCreateHandler(), null);
register('GET',  '/project/:projectid/path/:pathid', new ProjectPathChildrenGetHandler(), null);

register('GET',  '/text/code/:code', 						new TextCodeGetHandler(), null);
register('POST', '/text', 									new TextCreateHandler(), null);
register('GET',  '/text/project/:projectid/path/:pathid', 	new TextPathGetHandler(), null);
register('POST', '/text/:textid/publish', 					new TextPublishHandler(), null);
register('PUT',  '/text/:textid/upload', 					new TextUpdateHandler(), null);
?>
