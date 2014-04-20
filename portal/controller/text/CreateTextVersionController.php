<?php
class CreateTextVersionController extends ViewController {

	protected function control() {
		$projectId = param('project_id');
	
		global $_CSESSION;
		$project = new Project($projectId);

		if ($project->isAvailableToUser($_CSESSION->getUserId())) {
			$textId = param('text_id');

			$text = new Text($textId);

			$content = param('content');

			if (isset($content)) {
				$text->addNewVersion($content);
			}
		}

		$this->redirect('/text/detail?project_id='.$projectId.'&id='.$textId);

//		$this->response(array());
	}
}
?>