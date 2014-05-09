<?php
class ImageToPathController extends ViewController {

	protected function control() {
		$projectId = param('application_id');

		global $_CSESSION;
		$project = new Project($projectId);

		if ($project->isAvailableToUser($_CSESSION->getUserId())) {
			$projPathId = param('project_path_id');

			$pathExist = ProjectPathDao::hasProjectPath($projectId, $projPathId);

			if (!$pathExist) {
				$this->response(array('status'=>'failed'), '409 Conflict');
			}

			$action = param('action');

			if (empty($action)) {
				$this->response(array('status'=>'failed'), '404 Bad Request');
			}

			$imageId = param('image_id');

			$image = new Image($imageId);

			if ($action=='add') {
				$result = $image->addToProjectPath($projPathId);
			} else if ($action=='remove') {
				$result = $image->removeFromProjectPath($projPathId);
			}

			if ($result) {
				$this->response(array('status'=>'success'));
			} else {
				$this->response(array('status'=>'failed'), '500 Internal Server Error');
			}
		}

		$this->response(array('status'=>'failed'), '403 Forbidden');
	}
}
?>