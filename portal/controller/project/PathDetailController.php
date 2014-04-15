<?php
class PathDetailController extends ViewController {

	protected function control() {
		$this->render( array(
			'title' => 'Project Path Detail | Confone',
			'view' => 'project/path-detail.php'
		));
	}
}
?>