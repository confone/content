<?php
class CreateImageVersionController extends ViewController {

	protected function control() {
		$projectId = param('application_id');

		global $_CSESSION;
		$project = new Project($projectId);

		if ($project->isAvailableToUser($_CSESSION->getUserId())) {
			global $image_upload_dir, $image_separator;

			$fileName = date('YmdHis').'_'.$_CSESSION->getUserId().'_'.rand(1, 10000).$image_separator.$_FILES['file']['name'];

			$saved = move_uploaded_file($_FILES['file']['tmp_name'], $image_upload_dir.$fileName);

			if ($saved) {
				$imageId = param('image_id');

				$image = new Image($imageId);

				if (isset($fileName)) {
					$image->addNewVersion($fileName);
				}
			} else {
				header('HTTP/1.0 500 Internal Server Error');
				$response = array('status' => 'error');
				$response['description'] = 'Cannot Save File!';
				$this->response($response);
			}
		}

		$this->response(array('status' => 'success'));
	}
}
?>