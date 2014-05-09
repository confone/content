<?php
class PublishImagePreviewController extends ViewController {

	protected function control() {
		$projectId = param('application_id');
	
		global $_CSESSION;
		$project = new Project($projectId);

		if ($project->isAvailableToUser($_CSESSION->getUserId())) {
			$imageId = param('image_id');

			$image = new Image($imageId);

			$image->publishNewVersion();
		}

		$this->redirect('/image/detail?application_id='.$projectId.'&id='.$imageId);

//		$this->response(array());
	}
}
?>