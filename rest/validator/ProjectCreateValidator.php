<?php
class ProjectCreateValidator extends Validator {

	public function validate() {
		$body = $this->getObjectToBeValidated();
	}
}
?>