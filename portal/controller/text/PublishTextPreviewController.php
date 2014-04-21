<?php
class PublishTextPreviewController extends ViewController {

	protected function control() {
		$projectId = param('project_id');
	
		global $_CSESSION;
		$project = new Project($projectId);

		if ($project->isAvailableToUser($_CSESSION->getUserId())) {
			$textId = param('text_id');
			$language = param('language');

			$text = new Text($textId);

			$text->publishNewVersion($language);
		}

		$this->redirect('/text/detail?project_id='.$projectId.'&id='.$textId);

//		$this->response(array());
	}
}
?>