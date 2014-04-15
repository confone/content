<?php
class TextDao extends TextDaoParent {

// =============================================== public function =================================================

	public static function getAllTexts($projectId, $projectPathId=0) {
		$paths = ProjectPathDao::getChildrenPath($projectId, $projectPathId);

		$atReturn = array();
		foreach ($paths as $path) {
			$ppid = $projectPathId!=0 ? $projectPathId : $projectId;
			$textId = LookupTextProjectPathDao::getTextIds($ppid);
			$text = new TextDao($textId);
			array_push($atReturn, $text);
		}

		return $atReturn;
	}

	public static function getTextsByCode($code, $projectId) {
		$textIds = LookupTextCodeDao::getTextId($code, $projectId);

		$atReturn = array();
		foreach ($textIds as $textId) {
			$text = new TextDao($textId);
			array_push($atReturn, $text);
		}

		return $atReturn;
	}

// ============================================ override functions ==================================================

	protected function beforeInsert() {
		$lookup = new LookupTextCodeDao();
		$lookup->var[LookupTextCodeDao::CODE] = $this->var[TextDao::CODE];
		$lookup->var[LookupTextCodeDao::TEXTID] = $this->var[TextDao::IDCOLUMN];
		$lookup->var[LookupTextCodeDao::PROJECTID] = $this->var[TextDao::PROJECTID];
		$lookup->save();

		$projectPathId = $this->var[TextDao::PROJECTPATHID];
		$projectId = $this->var[TextDao::PROJECTID];

		$lookup = new LookupTextProjectPathDao();
		$lookup->var[LookupTextProjectPathDao::PROJECTPATHID] = $projectPathId!=0 ? $projectPathId : $projectId;
		$lookup->var[LookupTextProjectPathDao::TEXTID] = $this->var[TextDao::IDCOLUMN];
		$lookup->save();
	}

	protected function isShardBaseObject() {
		return true;
	}
}
?>