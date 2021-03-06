<?php
class ImageDisplayHandler extends Handler {

	protected function handle($params) {
		if (!LookupImageCodeDao::hasImageCode($params['code'], $params['imageid'])) {
			header('HTTP/1.0 404 Not Found');
			return array('status'=>'error', 'description'=>'Image Not Found');
		}

		$imageVersionDao = ImageVersionDao::getCurrentImage($params['imageid']);

		if (!$imageVersionDao) {
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
		} else if (strtolower($type)=='ico' || strtolower($type)=='cur') {
			$type = 'png';
		}

		$filePath = $image_upload_dir.$file;

    	header('Content-Type: image/'.$type);
		readfile($filePath);
	}
}
?>