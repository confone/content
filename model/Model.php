<?php
abstract class Model {

	private $id = null;

	public function __construct($id) {
		$this->id = $id;
		$this->init();
	}

	public function getId() {
		return $this->id;
	}

	abstract protected function init();

    abstract public function persist();
}
?>