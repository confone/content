<?php
class LookupProjectAccountDao extends LookupProjectAccountDaoParent {

// =============================================== public function =================================================

	public static function getLookupsByAccountId($accountId) {
		$lookup = new LookupProjectAccountDao();
		$sequence = $accountId;
		$lookup->setServerAddress($sequence);

		$builder = new QueryBuilder($lookup);
		$rows = $builder->select('*')
						->where('account_id', $accountId)
						->findList();

		return ContentDaoBase::makeObjectsFromSelectListResult($rows, "LookupProjectAccountDao");
	}

	public static function getUserAccessLevelOnProject($projectId, $accountId) {
		$lookup = new LookupProjectAccountDao();
		$sequence = $accountId;
		$lookup->setServerAddress($sequence);

		$builder = new QueryBuilder($lookup);
		$res = $builder->select('access_level')
					   ->where('project_id', $projectId)
					   ->where('account_id', $accountId)
					   ->find();

		if ($res) {
			return $res['access_level'];
		} else {
			return ProjectDao::ACCESSLEVEL_NONE;
		}
	}

	public static function removeLookup($projectId, $accountId) {
		$lookup = new LookupProjectAccountDao();
		$sequence = $accountId;
		$lookup->setServerAddress($sequence);

		$builder = new QueryBuilder($lookup);
		$res = $builder->delete()
					   ->where('project_id', $projectId)
					   ->where('account_id', $accountId)
					   ->query();

		return $res;
	}

// ============================================ override functions ==================================================

	protected function beforeInsert() {
		$this->setAccessLevel(ProjectDao::ACCESSLEVEL_READ);

		$sequence = $this->getAccountId();
		$this->setShardId($sequence);
	}

	protected function beforeUpdate() {
		$sequence = $this->getAccountId();
		$this->setServerAddress($sequence);
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>