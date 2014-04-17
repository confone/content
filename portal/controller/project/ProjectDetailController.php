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

		$this->render( array(
			'title' => 'Project Information | Confone',
			'view' => 'project/detail.php',
			'project' => $project
		));
	}
}
?>