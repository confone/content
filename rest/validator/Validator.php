<?php
abstract class Validator {

    private $toBeValidated = null;
    private $message = array("status"=>"success","description"=>"OK");

    public function getMessage() {
        return $this->message;
    }

    public function setObjectToBeValidated($object) {
        $this->toBeValidated = $object;
    }

    protected function getObjectToBeValidated() {
        return $this->toBeValidated;
    }

    protected function setErrorMessage($message) {
        $this->message = array("status"=>"error","description"=>$message);
    }

    protected function nonEmptyArrayIndex($indexes, $array) {
        $valid = true;
        foreach ($indexes as $index) {
            if (!$valid) { break; }
            if (isset($array[$index])) {
                $valid = $this->nonEmpty($array[$index], 'missing '.$index);
            } else {
                $valid = false;
                header('HTTP/1.0 400 Bad Request');
                $this->setErrorMessage('missing '.$index);
            }
        }
        return $valid;
    }

    protected function nonEmpty($obj, $message) {
        $valid = !empty($obj) || is_bool($obj) || is_numeric($obj);
        if (!$valid) { 
            header('HTTP/1.0 400 Bad Request');
            $this->setErrorMessage($message); 
        }
        return $valid; 
    }

    abstract public function validate();
}
?>