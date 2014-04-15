<?php
class ProjectDetailController extends ViewController {

	protected function control() {
		Logger::info('I am here ...');

		$this->render( array(
			'title' => 'Project Information | Confone',
			'view' => 'project/detail.php'
		));
	}
}
?>