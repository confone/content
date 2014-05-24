<?php
class CreateProjectController extends ViewController {

	protected function control() {
		global $_CSESSION;

		$user = new User($_CSESSION->getUserId());

		$name = param('project_name');
		if (!empty($name)) {
			if ($user->addProject($name, param('project_description'))) {
				$this->redirect('/application/list');
			} else {
				$error = 'System Temporarily NOT available!';
			}
		}

		$this->redirect('/application/list');

//		$this->response(array());
	}
}
?>