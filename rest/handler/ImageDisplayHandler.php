<?php
class ImageDisplayHandler extends Handler {

	protected function handle($params) {
		$imageVersionDao = ImageVersionDao::getCurrentImage($params['imageid']);

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