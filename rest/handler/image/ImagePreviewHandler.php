<?php
class ImagePreviewHandler extends Handler {

	protected function handle($params) {
		$imageVersionDao = ImageVersionDao::getPreviewImage($params['imageid']);

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