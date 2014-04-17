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

		$this->redirect('/project/list');

//		$this->response(array());
	}
}
?>