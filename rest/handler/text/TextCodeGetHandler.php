<?php
class TextCodeGetHandler extends Handler {

	protected function handle($params) {
		$code = $params['code'];

		global $_PROJECTID, $base_host, $base_uri;

		$textId = LookupTextCodeDao::lookupTextId($code, $_PROJECTID);

		$textVersions = TextVersionDao::getTexts($textId);

		$response = array();
		$response['status'] = 'success';
		$response['texts'] = array();

		foreach ($textVersions as $version) {
			$ver = $version->getVersion();
			if (!isset($response['texts'][$version->getLanguage()])) {
				$response['texts'][$version->getLanguage()] = array();
			}
			$response['texts'][$version->getLanguage()][$ver] = array();
			$response['texts'][$version->getLanguage()][$ver]['content'] = $version->getContent();
		}

		return $response;
	}
}
?>