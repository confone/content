<?php
class TextDao extends TextDaoParent {

// =============================================== public function =================================================

	public static function getTexts($projectId, $projectPathId) {
		$texts = array();

		$ids = LookupTextProjectPathDao::getTextIds($projectId, $projectPathId);

		foreach ($ids as $id) {
			array_push($texts, new TextDao($id));
		}

		return $texts;
	}

	public static function getTextsByCode($code, $projectId) {
		$textId = LookupTextCodeDao::lookupTextId($code, $projectId);

		$textDao = new ImageDao($textId);

		return $atReturn;
	}

// ============================================ override functions ==================================================

	protected function beforeInsert() {
		$lookup = new LookupTextCodeDao();
		$lookup->setCode($this->getCode());
		$lookup->setTextId($this->getId());
		$lookup->setProjectId($this->getProjectId());
		$lookup->save();
	}

	protected function isShardBaseObject() {
		return true;
	}
}
?>