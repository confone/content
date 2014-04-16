<?php
class ProjectDetailController extends ViewController {

	protected function control() {
		$projectId = param('id');

		if (!isset($projectId)) {
			$this->redirect('/project/list');
		}

		$project = new Project($projectId);

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