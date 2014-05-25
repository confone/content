<?php
class CreateTextVersionController extends ViewController {

	protected function control() {
		$projectId = param('application_id');
	
		global $_CSESSION;
		$project = new Project($projectId);

		if ($project->isAvailableToUser($_CSESSION->getUserId())) {
			$textId = param('text_id');

			$text = new Text($textId);

			$content = param('content');
			$language = param('language');

			if (isset($content)) {
				$text->addNewVersion($content, $language);
			}
		}

		$this->redirect('/text/detail?application_id='.$projectId.'&id='.$textId);

//		$this->response(array());
	}
}
?>