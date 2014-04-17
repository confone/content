<?php
class ImageToPathController extends ViewController {

	protected function control() {
		$this->render( array(
			'title' => 'Image Detail | Confone',
			'view' => 'image/detail.php'
		));
	}
}
?>