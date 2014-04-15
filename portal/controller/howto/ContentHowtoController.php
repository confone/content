<?php
class ContentHowtoController extends ViewController {

	protected function control() {
		$this->render( array(
			'title' => 'How to use Content Management Services | Confone',
			'view' => 'howto/index.php'
		));
	}
}
?>