<?php
class PathDetailController extends ViewController {

	protected function control() {
		$projectId = param('project_id');

		if (!isset($projectId)) {
			$this->redirect('/project/list');
		}

		global $_CSESSION;

		$project = new Project($projectId);

		if (!$project->isAvailableToUser($_CSESSION->getUserId())) {
			$this->redirect('/project/list');
		}

		$projectPathId = param('id');

		$projectPath = new ProjectPath($projectId, $projectPathId);

		$this->render( array(
			'title' => 'Project Path Detail | Confone',
			'view' => 'project/path-detail.php',
			'projectId' => $projectId,
			'projectPath' => $projectPath
		));
	}
}
?>