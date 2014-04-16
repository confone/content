<?php
abstract class Model {
	private $dao = null;

	public function __construct($dao) {
		$this->dao = $dao;
	}

	public function getId() {
		return $this->dao->getId();
	}

	protected function getDao() {
		return $this->dao;
	}

    public function persist() {
    	$this->dao->save();
    }
}
?>