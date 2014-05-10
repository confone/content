<?php
class CreateTextController extends ViewController {

	protected function control() {
		$projectId = param('application_id');

		global $_CSESSION;
		$project = new Project($projectId);

		if ($project->isAvailableToUser($_CSESSION->getUserId())) {
			$projPathId = param('project_path_id');

			$code = param('code');

			if ($project->hasTextCode($code)) {
				$this->redirect('/application/detail?id='.$projectId.'&err=text code already exists');
			}

			$textId = $project->addText($code, true);

			$isProjectPath = false;
			if (isset($projPathId) && $projPathId>0) {
				$projPath = new ProjectPath($projectId, $projPathId);
				$projPath->addText($textId);
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