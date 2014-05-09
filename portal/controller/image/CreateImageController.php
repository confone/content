<?php
class CreateImageController extends ViewController {

	protected function control() {
		$projectId = param('application_id');

		global $_CSESSION;
		$project = new Project($projectId);

		if ($project->isAvailableToUser($_CSESSION->getUserId())) {
			$projPathId = param('project_path_id');

			$code = param('code');

			$imageId = $project->addImage($code);

			$isProjectPath = false;
			if (isset($projPathId) && $projPathId>0) {
				$projPath = new ProjectPath($projectId, $projPathId);
				$projPath->addImage($imageId);
				$isProjectPath = true;
			}
		}

		if ($isProjectPath) {
			$this->redirect('/application/group?application_id='.$projectId.'&id='.$projPathId);
		}

		$this->redirect('/application/detail?id='.$projectId);

//		$this->response(array());
	}
}
?>