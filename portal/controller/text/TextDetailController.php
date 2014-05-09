<?php
class TextDetailController extends ViewController {

	protected function control() {
		$projectId = param('application_id');

		global $_CSESSION;
		$project = new Project($projectId);

		if (!$project->isAvailableToUser($_CSESSION->getUserId())) {
			$this->redirect('/application/list');
		}

		$textId = param('id');

		$text = new Text($textId);

		if ($text->getProjectId()!=$projectId) {
			$this->redirect('/application/list');
		} else if ($text->getAccountId()!=$_CSESSION->getUserId()) {
			$this->redirect('/application/list');
		}

		$this->render( array(
			'title' => 'Text Detail | Confone',
			'view' => 'text/detail.php',
			'project' => $project,
			'text' => $text
		));
	}
}
?>