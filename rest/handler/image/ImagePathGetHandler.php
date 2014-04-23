<?php
class ImagePathGetHandler extends Handler {

	protected function handle($params) {
		$response = array();
		$response['status'] = 'success';

		$pathName = $params['pathname'];

		global $_PROJECTID, $base_host, $base_uri;

		$projectPathDao = ProjectPathDao::getProjectPathIdByPathName($_PROJECTID, $pathName);

		$idAndCodes = LookupImageProjectPathDao::getImageIdsAndCodes($_PROJECTID, $projectPathDao->getId());

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