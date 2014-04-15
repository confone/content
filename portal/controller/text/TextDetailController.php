<?php
class TextDetailController extends ViewController {

	protected function control() {
		$this->render( array(
			'title' => 'Text Detail | Confone',
			'view' => 'text/detail.php'
		));
	}
}
?>