<?php
class TextCreateValidator extends Validator {

	public function validate() {
		$body = $this->getObjectToBeValidated();
	}
}
?>