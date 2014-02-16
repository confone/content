<?php
abstract class Handler {

    private $validator;

    public function execute($params) {
        if (isset($this->validator)) {
            $json = Utility::getJsonRequestData();

            if (empty($json)) {
                $raw = Utility::getRawRequestData();

                if (empty($raw)) { 
                	$json = array(); 
                }
                else { 
                	$response = array('status'=>'error','description'=>'invalid_json_format'); 
                }  
            }

            $json = empty($_GET) ? $json : array_merge($_GET, $json);

            $tobeValidated = empty($params) ? $json : array_merge($params, $json);

            $this->validator->setObjectToBeValidated($tobeValidated);

            if ($this->validator->validate()) {
                $response = $this->handle($params);
            } else {
                $response = $this->onValidationFailed();
            }
        } else {
            $response = $this->handle($params);
        }

        $response = json_encode($response);

        return $response;
    }

    public function setValidator($validator) {
    	$this->validator = $validator;
    }

    protected function getValidator() {
    	return $this->validator;
    }

    abstract protected function handle($params);
}