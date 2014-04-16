<?php
abstract class Model {

	private $input = null;

	public function __construct() {
		$a = func_get_args(); 
        $i = func_num_args(); 
        if (method_exists($this,$f='__construct'.$i)) { 
            call_user_func_array(array($this,$f),$a); 
        } 
	}

	private function __construct1($a1) {
		$this->input = $a1;
		$this->init();
	}

	private function __construct2($a1, $a2) {
		$this->input = array();
		$this->input[0] = $a1;
		$this->input[1] = $a2;
		$this->init();
	}

	private function __construct3($a1, $a2, $a3) {
		$this->input = array();
		$this->input[0] = $a1;
		$this->input[1] = $a2;
		$this->input[2] = $a3;
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