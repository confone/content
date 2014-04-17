<?php
class CreateProjectPathController extends ViewController {

	protected function control() {
		$projectId = param('project_id');
	
		global $_CSESSION;
		$project = new Project($projectId);

		if ($project->isAvailableToUser($_CSESSION->getUserId())) {
			$parentPathId = param('parent_path_id');

			if ($parentPathId==0) {
				$parentPath = $project->getRootPath();
			} else {
				$parentPath = new ProjectPath($projectId, $parentPathId);
			}

			$path = param('project_path');

			if (isset($path)) {
				$parentPath->addSubProjectPath($path);
			}
		}

		$this->redirect('/project/detail?id='.$projectId);

//		$this->response(array());
	}
}
?>