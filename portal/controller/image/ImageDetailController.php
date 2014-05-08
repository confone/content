<?php
class ImageDetailController extends ViewController {

	protected function control() {
		$projectId = param('project_id');

		global $_CSESSION;
		$project = new Project($projectId);

		if (!$project->isAvailableToUser($_CSESSION->getUserId())) {
			$this->redirect('/project/list');
		}

		$imageId = param('id');

		$image = new Image($imageId);

		if ($image->getProjectId()!=$projectId) {
			$this->redirect('/project/list');
		} else if ($image->getAccountId()!=$_CSESSION->getUserId()) {
			$this->redirect('/project/list');
		}

		$this->render( array(
			'title' => 'Image Detail | Confone',
			'view' => 'image/detail.php',
			'project' => $project,
			'image' => $image
		));
	}
}
?>