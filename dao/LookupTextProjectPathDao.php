<?php
class LookupTextProjectPathDao extends ContentDao {

	const TEXTID = 'text_id';
	const PROJECTPATHID = 'project_path_id';

	const IDCOLUMN = 'id';
	const SHARDDOMAIN = 'confone_lookup_text';
	const TABLE = 'text_project_path';


// =============================================== public function =================================================

	public static function getTextIds($projectPathId) {
		$lookup = new LookupTextProjectPathDao();
		$sequence = Utility::hashString($projectPathId);
		$lookup->setShardId($sequence);

		$sql = "SELECT ".LookupTextProjectPathDao::TEXTID." FROM ".LookupTextProjectPathDao::TABLE." WHERE "
				.LookupTextProjectPathDao::PROJECTPATHID."=$projectPathId";

		$connect = DBUtil::getConn($lookup);
		$rows = DBUtil::selectDataList($connect, $sql);

		if ($rows) {
			$atReturn = array();
			foreach ($rows as $row) {
				array_push($atReturn, $row[LookupTextProjectPathDao::TEXTID]);
			}
			return $atReturn;
		} else {
			return array();
		}
	}


// ============================================ override functions ==================================================

	protected function init() {
		$this->var[LookupTextProjectPathDao::IDCOLUMN] = 0;
		$this->var[LookupTextProjectPathDao::PROJECTPATHID] = 0;
		$this->var[LookupTextProjectPathDao::TEXTID] = 0;
	}

	protected function beforeInsert() {
		$sequence = Utility::hashString($this->var[LookupTextProjectPathDao::PROJECTPATHID]);
		$this->setShardId($sequence);
	}

	public function getShardDomain() {
		return LookupTextProjectPathDao::SHARDDOMAIN;
	}

	public function getTableName() {
		return LookupTextProjectPathDao::TABLE;
	}

	public function getIdColumnName() {
		return LookupTextProjectPathDao::IDCOLUMN;
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>