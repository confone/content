<?php
class TextPathGetHandler extends Handler {

	protected function handle($params) {
		$start = $_GET['start'];
		$size = $_GET['size'];

		$response = array();
		$response['status'] = 'success';

		$pathName = $params['pathname'];
		$headers = apache_request_headers();
		if (isset($headers['language'])) {
			$language = $headers['language'];
		} else {
			$language = 'en';
		}

		global $_PROJECTID, $base_host, $base_uri;

		$projectPathDao = ProjectPathDao::getProjectPathIdByPathName($_PROJECTID, $pathName);

		$idAndCodes = LookupTextProjectPathDao::getTextIdsAndCodes ( 
						$_PROJECTID, $projectPathDao->getId(), $start, $size );

		$response['texts'] = array();
		foreach ($idAndCodes as $idAndCode) {
			$isPreview = (isset($_GET['preview']) && $_GET['preview']=='true');
			if ($isPreview) {
				$textDao = TextVersionDao::getPreviewText($idAndCode['text_id'], $language);
			} else {
				$textDao = TextVersionDao::getCurrentText($idAndCode['text_id'], $language);
			}
			$response['texts'][$idAndCode['code']] = isset($textDao) ? $textDao->getContent() : '';
		}

		header('Content-type: text/html; charset=utf-8');
		return $response;
	}
}
?>