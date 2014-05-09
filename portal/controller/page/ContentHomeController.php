<?php
class ContentHomeController extends ViewController {

	protected function control() {
		$this->redirect('/project/list');

//		$this->render( array(
//			'title' => 'Content Management | Confone',
//			'view' => 'page/home.php'
//		));
	}
}
?>