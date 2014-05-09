<?php
class ProjectDetailController extends ViewController {

	protected function control() {
		$projectId = param('id');

		if (!isset($projectId)) {
			$this->redirect('/application/list');
		}

		global $_CSESSION;

		$project = new Project($projectId);

		if (!$project->isAvailableToUser($_CSESSION->getUserId())) {
			$this->redirect('/application/list');
		}

		$user = new User($_CSESSION->getUserId());
		$user->setName($_CSESSION->getUserName());
		$user->setProfileImage($_CSESSION->getUserProfileImage());

		$this->render( array(
			'title' => 'Project Information | Confone',
			'view' => 'project/detail.php',
			'project' => $project,
			'user' => $user
		));
	}
}
?>