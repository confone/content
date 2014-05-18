<?php
class ImageVersionHandler extends Handler {

	protected function handle($params) {
		if (!LookupImageCodeDao::hasImageCode($params['code'], $params['imageid'])) {
			header('HTTP/1.0 404 Not Found');
			return array('status'=>'error', 'description'=>'Image Not Found');
		}

		if (empty($params['version']) || !is_numeric($params['version'])) {
			header('HTTP/1.0 400 Bad Request');
			return array('status'=>'error', 'description'=>'Invalid Request');
		}

		$imageVersionDao = ImageVersionDao::getVersionImage($params['imageid'], $params['version']);

		if (!isset($imageVersionDao)) {
			global $image_none;
    		header('Content-Type: image/png');
			readfile($image_none);
			exit;
		}

		$file = $imageVersionDao->getFilePath();

		global $image_upload_dir;

		$type = strtolower(Utility::extension($file));

		if ($type=='jpg') {
			$type = 'jpeg';
		}

		$filePath = $image_upload_dir.$file;

    	header('Content-Type: image/'.$type);
		readfile($filePath);
	}
}
?>