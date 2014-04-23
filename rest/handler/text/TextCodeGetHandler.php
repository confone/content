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
			$ver = $version->getVersions();
			$response['texts'][$ver] = array();
			$response['texts'][$ver]['url'] = $base_host.$base_uri.'/text/display/'.$textId.'/version/'.$ver;
		}

		return $response;
	}
}
?>