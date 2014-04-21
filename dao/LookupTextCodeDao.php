<?php
class LookupTextCodeDao extends LookupTextCodeDaoParent {

// =============================================== public function =================================================

	public static function lookupTextId($code, $projectId) {
		$lookup = new LookupTextCodeDao();
		$sequence = Utility::hashString($code);
		$lookup->setServerAddress($sequence);

		$builder = new QueryBuilder($lookup);
		$res = $builder->select('text_id')
					   ->where('code', $code)
					   ->where('project_id', $projectId)
					   ->find();

		if ($res) {
			return $res['text_id'];
		} else {
			return 0;
		}
	}

// ============================================ override functions ==================================================

	protected function beforeInsert() {
		$sequence = Utility::hashString($this->getCode());
		$this->setShardId($sequence);
	}

	protected function beforeUpdate() {
		$sequence = Utility::hashString($this->getCode());
		$this->setServerAddress($sequence);
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>