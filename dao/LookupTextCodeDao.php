<?php
class LookupTextCodeDao extends ConfoneDao {

	const CODE = 'code';
	const TEXTID = 'text_id';
	const PROJECTPATHID = 'project_path_id';

	const IDCOLUMN = 'id';
	const SHARDDOMAIN = 'confone_lookup_text';
	const TABLE = 'text_code';


// =============================================== public function =================================================

	public static function getTextId($code, $projectPathId) {
		$lookup = new LookupTextCodeDao();
		$sequence = Utility::hashString($code);
		$lookup->setShardId($sequence);

		$sql = "SELECT ".LookupTextCodeDao::TEXTID." FROM ".LookupTextCodeDao::TABLE." WHERE "
				.LookupTextCodeDao::CODE."='$code' AND "
				.LookupTextCodeDao::PROJECTPATHID."='$projectPathId'";

		$connect = DBUtil::getConn($lookup);
		$res = DBUtil::selectData($connect, $sql);

		if ($res) {
			return $res[LookupTextCodeDao::TEXTID];
		} else {
			return 0;
		}
	}


// ============================================ override functions ==================================================

	protected function init() {
		$this->var[LookupTextCodeDao::IDCOLUMN] = 0;
		$this->var[LookupTextCodeDao::CODE] = 0;
		$this->var[LookupTextCodeDao::TEXTID] = 0;
		$this->var[LookupTextCodeDao::PROJECTPATHID] = 0;
	}

	protected function beforeInsert() {
		$sequence = Utility::hashString($this->var[LookupTextCodeDao::CODE]);
		$this->setShardId($sequence);
	}

	public function getShardDomain() {
		return LookupTextCodeDao::SHARDDOMAIN;
	}

	public function getTableName() {
		return LookupTextCodeDao::TABLE;
	}

	public function getIdColumnName() {
		return LookupTextCodeDao::IDCOLUMN;
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>