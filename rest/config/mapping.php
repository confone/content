<?php
register('GET',  '/image/code/:code', 						new ImageCodeGetHandler(), null);
register('POST', '/image', 									new ImageCreateHandler(),  new ImageCreateValidator());
register('GET',  '/image/display/:imageid', 				new ImageDisplayHandler(), null);
register('GET',  '/image/project/:projectid/path/:pathid', 	new ImagePathGetHandler(), null);
register('POST', '/image/:imageid/publish', 				new ImagePublishHandler(), new ImagePublishValidator());
register('PUT',  '/image/:imageid/upload', 					new ImageUpdateHandler(),  new ImageUpdateValidator());

register('POST', '/project', 						 new ProjectCreateHandler(), 		  new ProjectCreateValidator());
register('POST', '/project/:projectid/path', 		 new ProjectPathCreateHandler(), 	  new ProjectPathCreateValidator());
register('GET',  '/project/:projectid/path/:pathid', new ProjectPathChildrenGetHandler(), null);

register('GET',  '/text/code/:code', 						new TextCodeGetHandler(), null);
register('POST', '/text', 									new TextCreateHandler(), new TextCreateValidator());
register('GET',  '/text/project/:projectid/path/:pathid', 	new TextPathGetHandler(), null);
register('POST', '/text/:textid/publish', 					new TextPublishHandler(), new TextPublishValidator());
register('PUT',  '/text/:textid/upload', 					new TextUpdateHandler(), new TextUpdateValidator());
?>
