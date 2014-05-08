<?php
class TextToPathController extends ViewController {

	protected function control() {
		$projectId = param('project_id');

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

			$textId = param('text_id');

			$text = new Text($textId);

			if ($action=='add') {
				$result = $text->addToProjectPath($projPathId);
			} else if ($action=='remove') {
				$result = $text->removeFromProjectPath($projPathId);
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