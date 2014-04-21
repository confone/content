<?php
class LookupImageCodeDao extends LookupImageCodeDaoParent {

// =============================================== public function =================================================

	public static function lookupImageId($code, $projectId) {
		$lookup = new LookupImageCodeDao();
		$sequence = Utility::hashString($code);
		$lookup->setServerAddress($sequence);

		$builder = new QueryBuilder($lookup);
		$res = $builder->select('image_id')
					   ->where('code', $code)
					   ->where('project_id', $projectId)
					   ->find();

		if ($res) {
			return $res['image_id'];
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