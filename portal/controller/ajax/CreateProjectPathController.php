<?php
class CreateProjectPathController extends ViewController {

	protected function control() {
		$projectId = param('application_id');
	
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

			if (!empty($path)) {
				$parentPath->addSubProjectPath($path);
			}
		}

		$this->redirect('/application/detail?id='.$projectId);

//		$this->response(array());
	}
}
?>