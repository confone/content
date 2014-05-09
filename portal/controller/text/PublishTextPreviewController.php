<?php
class PublishTextPreviewController extends ViewController {

	protected function control() {
		$projectId = param('application_id');
	
		global $_CSESSION;
		$project = new Project($projectId);

		if ($project->isAvailableToUser($_CSESSION->getUserId())) {
			$textId = param('text_id');
			$language = param('language');

			$text = new Text($textId);

			$text->publishNewVersion($language);
		}

		$this->redirect('/text/detail?application_id='.$projectId.'&id='.$textId);

//		$this->response(array());
	}
}
?>