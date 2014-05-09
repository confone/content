<?php
class ContentHomeController extends ViewController {

	protected function control() {
		$this->redirect('/application/list');

//		$this->render( array(
//			'title' => 'Content Management | Confone',
//			'view' => 'page/home.php'
//		));
	}
}
?>