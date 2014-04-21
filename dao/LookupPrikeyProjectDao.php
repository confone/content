<?php
class LookupPrikeyProjectDao extends LookupPrikeyProjectDaoParent {

// =============================================== public function =================================================

	public static function lookupProjectIdByPrivateKey($prikey) {
		$lookup = new LookupPrikeyProjectDao();
		$sequence = Utility::hashString($prikey);
		$lookup->setServerAddress($sequence);

		$builder = new QueryBuilder($lookup);
		$res = $builder->select('project_id')->where('pri_key', $prikey)->find();

		if ($res) {
			return $res['project_id'];
		} else {
			return 0;
		}
	}

// ============================================ override functions ==================================================

	protected function beforeInsert() {
		$sequence = Utility::hashString($this->getPriKey());
		$this->setShardId($sequence);
	}

	protected function beforeUpdate() {
		$sequence = Utility::hashString($this->getPriKey());
		$this->setServerAddress($sequence);
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>