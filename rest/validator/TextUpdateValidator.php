<?php
class TextUpdateValidator extends Validator {

	public function validate() {
		$body = $this->getObjectToBeValidated();
	}
}
?>