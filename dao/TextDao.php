<?php
class TextDao extends ConfoneDao {

	const CODE = 'code';
	const PROJECTID = 'project_id';
	const PROJECTPATHID = 'project_path_id';
	const ACCOUNTID = 'account_id';
	const CREATETIME = 'create_time';
	const LASTMODIFY = 'last_modify';

	const IDCOLUMN = 'id';
	const SHARDDOMAIN = 'confone_text';
	const TABLE = 'text';


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

	protected function init() {
		$this->var[TextDao::IDCOLUMN] = 0;
		$this->var[TextDao::CODE] = '';
		$this->var[TextDao::PROJECTID] = 0;
		$this->var[TextDao::PROJECTPATHID] = 0;
		$this->var[TextDao::ACCOUNTID] = 0;

		$date = gmdate('Y-m-d H:i:s');
		$this->var[TextDao::CREATETIME] = $date;
		$this->var[TextDao::LASTMODIFY] = $date;
	}

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

	public function getShardDomain() {
		return TextDao::SHARDDOMAIN;
	}

	public function getTableName() {
		return TextDao::TABLE;
	}

	public function getIdColumnName() {
		return TextDao::IDCOLUMN;
	}

	protected function isShardBaseObject() {
		return true;
	}
}
?>