<?php
class CreateProjectPathController extends ViewController {

	protected function control() {
		$projectId = param('project_id');
	
		global $_CSESSION;
		$project = new Project($projectId);

		if ($project->isAvailableToUser($_CSESSION->getUserId())) {
			$parentPathId = param('parent_path_id');

			$projectPath = new ProjectPath($projectId, $parentPathId);

			$path = param('project_path');

			if (isset($path)) {
				$projectPath->addSubProjectPath($path);
			}
		}

		$this->redirect('/project/detail?id='.$projectId);

//		$this->response(array());
	}
}
?>