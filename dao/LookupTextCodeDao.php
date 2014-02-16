<?php
class LookupTextCodeDao extends ConfoneDao {

	const CODE = 'code';
	const TEXTID = 'text_id';
	const PROJECTID = 'project_id';

	const IDCOLUMN = 'id';
	const SHARDDOMAIN = 'confone_lookup_text';
	const TABLE = 'text_code';


// =============================================== public function =================================================

	public static function getTextId($code, $projectId) {
		$lookup = new LookupTextCodeDao();
		$sequence = Utility::hashString($code);
		$lookup->setShardId($sequence);

		$sql = "SELECT ".LookupTextCodeDao::TEXTID." FROM ".LookupTextCodeDao::TABLE." WHERE "
				.LookupTextCodeDao::CODE."='$code' AND "
				.LookupTextCodeDao::PROJECTID."=$projectId";

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
		$this->var[LookupTextCodeDao::PROJECTID] = 0;
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