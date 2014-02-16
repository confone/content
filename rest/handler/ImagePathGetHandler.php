<?php
class ImagePathGetHandler extends Handler {

	protected function handle($params) {
		$body = Utility::getJsonRequestData();

		$response = array();
		$response['status'] = 'success';

		return $response;
	}
}
?>