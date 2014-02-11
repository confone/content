<?php
class LookupProjectAccountDao extends ConfoneDao {

	const PROJECTID = 'project_id';
	const ACCOUNTID = 'account_id';
	const ACCESSLEVEL = 'access_level';

	const IDCOLUMN = 'id';
	const SHARDDOMAIN = '';
	const TABLE = '';


// =============================================== public function =================================================

	public static function getLookupsByAccountId($accountId) {
		$lookup = new LookupProjectAccountDao();
		$sequence = Utility::hashString($accountId);
		$lookup->setShardId($sequence);

		$sql = "SELECT * FROM ".LookupProjectAccountDao::TABLE." WHERE "
				.LookupProjectAccountDao::ACCOUNTID."=$accountId";

		$connect = DBUtil::getConn($lookup);
		$rows = DBUtil::selectDataList($connect, $sql);

		return $lookup->makeObjectsFromSelectListResult($rows, "LookupProjectAccountDao");
	}

	public static function getLookupsByProjectId($projectId, $shardAccountId) {
		$lookup = new LookupProjectAccountDao();
		$sequence = Utility::hashString($shardAccountId);
		$lookup->setShardId($sequence);

		$sql = "SELECT * FROM ".LookupProjectAccountDao::TABLE." WHERE "
				.LookupProjectAccountDao::PROJECTID."=$projectId";

		$connect = DBUtil::getConn($lookup);
		$rows = DBUtil::selectDataList($connect, $sql);

		return $lookup->makeObjectsFromSelectListResult($rows, "LookupProjectAccountDao");
	}

// ============================================ override functions ==================================================

	protected function init() {
		$this->var[LookupProjectAccountDao::IDCOLUMN] = 0;
		$this->var[LookupProjectAccountDao::PROJECTID] = 0;
		$this->var[LookupProjectAccountDao::ACCOUNTID] = 0;
		$this->var[LookupProjectAccountDao::ACCESSLEVEL] = 0;
	}

	protected function beforeInsert() {
		$sequence = Utility::hashString($this->var[LookupProjectAccountDao::ACCOUNTID]);
		$this->setShardId($sequence);
	}

	public function getShardDomain() {
		return LookupProjectAccountDao::SHARDDOMAIN;
	}

	public function getTableName() {
		return LookupProjectAccountDao::TABLE;
	}

	public function getIdColumnName() {
		return LookupProjectAccountDao::IDCOLUMN;
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>