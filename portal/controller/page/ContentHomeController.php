<?php
class ContentHomeController extends ViewController {

	protected function control() {
		$this->redirect('/application/list');

//		$this->render( array(
//			'title' => 'Content | Confone',
//			'view' => 'page/home.php'
//		));
	}
}
?>