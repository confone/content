<?php
class LookupImageCodeDao extends ContentDao {

	const CODE = 'code';
	const IMAGEID = 'image_id';
	const PROJECTID = 'project_id';

	const IDCOLUMN = 'id';
	const SHARDDOMAIN = 'confone_lookup_image';
	const TABLE = 'image_code';


// =============================================== public function =================================================

	public static function getImageId($code, $projectId) {
		$lookup = new LookupImageCodeDao();
		$sequence = Utility::hashString($code);
		$lookup->setShardId($sequence);

		$sql = "SELECT ".LookupImageCodeDao::IMAGEID." FROM ".LookupImageCodeDao::TABLE." WHERE "
				.LookupImageCodeDao::CODE."='$code' AND "
				.LookupTextCodeDao::PROJECTID."=$projectId";

		$connect = DBUtil::getConn($lookup);
		$res = DBUtil::selectData($connect, $sql);

		if ($res) {
			return $res[LookupImageCodeDao::IMAGEID];
		} else {
			return 0;
		}
	}


// ============================================ override functions ==================================================

	protected function init() {
		$this->var[LookupImageCodeDao::IDCOLUMN] = 0;
		$this->var[LookupImageCodeDao::CODE] = 0;
		$this->var[LookupImageCodeDao::IMAGEID] = 0;
		$this->var[LookupImageCodeDao::PROJECTID] = 0;
	}

	protected function beforeInsert() {
		$sequence = Utility::hashString($this->var[LookupImageCodeDao::CODE]);
		$this->setShardId($sequence);
	}

	public function getShardDomain() {
		return LookupImageCodeDao::SHARDDOMAIN;
	}

	public function getTableName() {
		return LookupImageCodeDao::TABLE;
	}

	public function getIdColumnName() {
		return LookupImageCodeDao::IDCOLUMN;
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>