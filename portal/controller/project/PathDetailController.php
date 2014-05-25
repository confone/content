<?php
class PathDetailController extends ViewController {

	protected function control() {
		$projectId = param('application_id');

		if (!isset($projectId)) {
			$this->redirect('/application/list');
		}

		global $_CSESSION;

		$project = new Project($projectId);

		if (!$project->isAvailableToUser($_CSESSION->getUserId())) {
			$this->redirect('/application/list');
		}

		$projectPathId = param('id');

		$projectPath = new ProjectPath($projectId, $projectPathId);

		$user = new User($_CSESSION->getUserId());
		$user->setName($_CSESSION->getUserName());
		$user->setProfileImage($_CSESSION->getUserProfileImage());

		$this->render( array(
			'title' => 'Project Path Detail | Confone',
			'view' => 'project/path-detail.php',
			'project' => $project,
			'projectPath' => $projectPath,
			'user' => $user
		));
	}
}
?>