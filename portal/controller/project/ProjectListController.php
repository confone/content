<?php
class ProjectListController extends ViewController {

	protected function control() {
		global $_CSESSION;

		$user = new User($_CSESSION->getUserId());
		$user->setName($_CSESSION->getUserName());
		$user->setProfileImage($_CSESSION->getUserProfileImage());

		$this->render( array(
			'title' => 'My Apps | Content Management',
			'view' => 'project/list.php',
			'user' => $user
		));
	}
}
?>