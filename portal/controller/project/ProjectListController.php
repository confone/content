<?php
class ProjectListController extends ViewController {

	protected function control() {

		$this->render( array(
			'title' => 'My Projects | Confone',
			'view' => 'project/list.php'
		));
	}
}
?>