<?php
class CreateTextController extends ViewController {

	protected function control() {
		$projectId = param('project_id');

		global $_CSESSION;
		$project = new Project($projectId);

		if ($project->isAvailableToUser($_CSESSION->getUserId())) {
			$projPathId = param('project_path_id');

			$code = param('code');

			$textId = $project->addText($code, true);

			$isProjectPath = false;
			if (isset($projPathId) && $projPathId>0) {
				$projPath = new ProjectPath($projectId, $projPathId);
				$textId = $project->addText($code);
				$projPath->addText($textId);
				$isProjectPath = true;
			}
		}

		if ($isProjectPath) {
			$this->redirect('/project/path?project_id='.$projectId.'&id='.$projPathId);
		}

		$this->redirect('/project/detail?id='.$projectId);

//		$this->response(array());
	}
}
?>