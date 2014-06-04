<?php
class ImagePathGetHandler extends Handler {

	protected function handle($params) {
		$start = $_GET['start'];
		$size = $_GET['size'];

		if (empty($start) || empty($size)) {
			header('HTTP/1.0 400 Bad Request');
			return array('status'=>'error', 'description'=>'missing GET parameters');
		} else if ($size>100) {
			header('HTTP/1.0 400 Bad Request');
			return array('status'=>'error', 'description'=>'succeeding max size 100');
		}

		$response = array();
		$response['status'] = 'success';

		$pathName = $params['pathname'];

		global $_PROJECTID, $base_host, $base_uri;

		$projectPathDao = ProjectPathDao::getProjectPathIdByPathName($_PROJECTID, $pathName);

		$idAndCodes = LookupImageProjectPathDao::getImageIdsAndCodes ( 
						$_PROJECTID, $projectPathDao->getId(), $start, $size );

		$response['images'] = array();
		foreach ($idAndCodes as $idAndCode) {
			$url = $base_host.$base_uri.'/image/display/'.$idAndCode['image_id'];
			$isPreview = (isset($_GET['preview']) && $_GET['preview']=='true');
			$response['images'][$idAndCode['code']] = $url.($isPreview ? '/preview' : '');
		}

		return $response;
	}
}
?>