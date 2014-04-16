<?php
class ProjectDetailController extends ViewController {

	protected function control() {
		$projectId = param('id');

		if (!isset($projectId)) {
			$this->redirect('/project/list');
		}

		global $_CSESSION;

		$project = new Project($projectId);

		if (!$project->isAvailableToUser($_CSESSION->getUserId())) {
			$this->redirect('/project/list');
		}

		$path = param('project_path');
		if (isset($path)) {
			$rootPath = $project->getRootPath();
			$rootPath->addSubProjectPath($path);
		}

		$this->render( array(
			'title' => 'Project Information | Confone',
			'view' => 'project/detail.php',
			'project' => $project
		));
	}
}
?>