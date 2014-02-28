<?php
class TextPublishValidator extends Validator {

	public function validate() {
		$body = $this->getObjectToBeValidated();
	}
}
?>