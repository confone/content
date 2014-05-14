<?php
class ContentHowtoController extends ViewController {

	protected function control() {
		$this->render( array(
			'title' => 'How to use Content Services | Confone',
			'view' => 'howto/index.php'
		));
	}
}
?>