<?php
class CreateImageVersionController extends ViewController {

	protected function control() {
		$projectId = param('project_id');
	
		global $_CSESSION;
		$project = new Project($projectId);

		if ($project->isAvailableToUser($_CSESSION->getUserId())) {
			$imageId = param('image_id');

			$image = new Image($imageId);

			$path = param('path');

			if (isset($path)) {
				$image->addNewVersion($path);
			}
		}

		$this->redirect('/image/detail?project_id='.$projectId.'&id='.$imageId);

//		$this->response(array());
	}
}
?>