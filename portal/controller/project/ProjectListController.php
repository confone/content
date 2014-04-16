<?php
class ProjectListController extends ViewController {

	protected function control() {
		global $_CSESSION;

		$user = new User($_CSESSION->getUserId());

		$this->render( array(
			'title' => 'My Projects | Confone',
			'view' => 'project/list.php',
			'user' => $user
		));
	}
}
?>