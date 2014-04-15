<?php
class LookupPubkeyProjectDao extends LookupPubkeyProjectDaoParent {

// =============================================== public function =================================================

	public static function lookupProjectIdByPubvateKey($pubkey) {
		$lookup = new LookupPubkeyProjectDao();
		$sequence = Utility::hashString($pubkey);
		$lookup->setShardId($sequence);

		$builder = new QueryBuilder($lookup);
		$res = $builder->select('project_id')->where('pub_key', $pubkey)->find();

		if ($res) {
			return $res['project_id'];
		} else {
			return 0;
		}
	}

// ============================================ override functions ==================================================

	protected function beforeInsert() {
		$sequence = Utility::hashString($this->getPubKey());
		$this->setShardId($sequence);
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>