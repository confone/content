<?php
abstract class Model {

	private $input = null;

	public function __construct($input) {
		$this->input = $input;
		$this->init();
	}

	protected function &getInput() {
		return $this->input;
	}

	abstract public function getId();

	abstract protected function init();

    abstract public function persist();
}
?>