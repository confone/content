<?php
class LookupImageProjectPathDao extends ContentDao {

	const IMAGEID = 'image_id';
	const PROJECTPATHID = 'project_path_id';

	const IDCOLUMN = 'id';
	const SHARDDOMAIN = 'confone_lookup_image';
	const TABLE = 'image_project_path';


// =============================================== public function =================================================

	public static function getImageIds($projectPathId) {
		$lookup = new LookupImageProjectPathDao();
		$sequence = Utility::hashString($projectPathId);
		$lookup->setShardId($sequence);

		$sql = "SELECT ".LookupImageProjectPathDao::IMAGEID." FROM ".LookupImageProjectPathDao::TABLE." WHERE "
				.LookupImageProjectPathDao::PROJECTPATHID."=$projectPathId";

		$connect = DBUtil::getConn($lookup);
		$rows = DBUtil::selectDataList($connect, $sql);

		if ($rows) {
			$atReturn = array();
			foreach ($rows as $row) {
				array_push($atReturn, $row[LookupImageProjectPathDao::IMAGEID]);
			}
			return $atReturn;
		} else {
			return array();
		}
	}


// ============================================ override functions ==================================================

	protected function init() {
		$this->var[LookupImageProjectPathDao::IDCOLUMN] = 0;
		$this->var[LookupImageProjectPathDao::PROJECTPATHID] = 0;
		$this->var[LookupImageProjectPathDao::IMAGEID] = 0;
	}

	protected function beforeInsert() {
		$sequence = Utility::hashString($this->var[LookupImageProjectPathDao::PROJECTPATHID]);
		$this->setShardId($sequence);
	}

	public function getShardDomain() {
		return LookupImageProjectPathDao::SHARDDOMAIN;
	}

	public function getTableName() {
		return LookupImageProjectPathDao::TABLE;
	}

	public function getIdColumnName() {
		return LookupImageProjectPathDao::IDCOLUMN;
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>