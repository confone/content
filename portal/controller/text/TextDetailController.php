<?php
class TextDetailController extends ViewController {

	protected function control() {
		$projectId = param('project_id');

		global $_CSESSION;
		$project = new Project($projectId);

		if (!$project->isAvailableToUser($_CSESSION->getUserId())) {
			$this->redirect('/project/list');
		}

		$textId = param('id');

		$text = new Text($textId);

		if ($text->getProjectId()!=$projectId) {
			$this->redirect('/project/list');
		} else if ($text->getAccountId()!=$_CSESSION->getUserId()) {
			$this->redirect('/project/list');
		}

		$this->render( array(
			'title' => 'Text Detail | Confone',
			'view' => 'text/detail.php',
			'text' => $text
		));
	}
}
?>