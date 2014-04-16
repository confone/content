<?php
class CreateProjectController extends ViewController {

	protected function control() {
		global $_CSESSION;

		$user = new User($_CSESSION->getUserId());

		$name = param('project_name');
		if (isset($name)) {
			if ($user->addProject($name)) {
				$this->redirect('/project/list');
			} else {
				$error = 'System Temporarily NOT available!';
			}
		}

		$this->render( array(
			'title' => 'New Content Management Project | Confone',
			'view' => 'project/new.php',
			'error' => isset($error) ? $error : null
		));
	}
}
?>