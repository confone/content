<?php
class ImageCodeGetHandler extends Handler {

	protected function handle($params) {
		$code = $params['code'];

		global $_PROJECTID, $base_host, $base_uri;

		$imageId = LookupImageCodeDao::lookupImageId($code, $_PROJECTID);

		$imageVersions = ImageVersionDao::getImages($imageId);

		$response = array();
		$response['status'] = 'success';
		$response['images'] = array();

		foreach ($imageVersions as $version) {
			$ver = $version->getVersion();
			$response['images'][$ver] = array();
			$response['images'][$ver]['url'] = $base_host.$base_uri.'/image/display/'.$imageId.'/version/'.$ver;
		}

		return $response;
	}
}
?>