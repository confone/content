<?php
class ContentHomeController extends ViewController {

	protected function control() {
		Logger::info('I am here ...');

		$this->render( array(
			'title' => 'Content Management | Confone',
			'view' => 'page/home.php'
		));
	}
}
?>