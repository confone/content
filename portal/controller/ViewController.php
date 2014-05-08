<?php
abstract class ViewController {

	protected function render($params) {
		foreach ($params as $key=>$val) {
			${$key} = $val;
		}

		if (file_exists('view/'.$view)) {
			include 'view/'.$view;
		} else {
			throw new Exception('View does not exist.');
			Logger::error('View '.$view.' does not exist.');
		}
	}

	protected function redirect($url) {
		header('Location: '.$url);
		exit;
	}

	protected function response($body, $status='200 OK') {
		header('HTTP/1.0 '.$status);
		echo json_encode($body);
		exit;
	}

	public function execute() {
		if ($this->checkLogin()) {
			global $base_host, $account_url, $_CSESSION, $_URI;
			if (!$_CSESSION->hasUserId()) {
				$this->redirect($account_url.'/login?redirect_uri='.$base_host.$_URI);
			}
		}

		$this->control();
	}

	protected function checkLogin() {
		return true;
	}

	abstract protected function control();
}
?>