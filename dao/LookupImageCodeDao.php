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

	public static function hasProjectImageCode($code, $projectId) {
		$lookup = new LookupImageCodeDao();
		$sequence = Utility::hashString($code);
		$lookup->setServerAddress($sequence);

		$builder = new QueryBuilder($lookup);
		$res = $builder->select('COUNT(*) as count')
					   ->where('code', $code)
					   ->where('project_id', $projectId)
					   ->find();

		return $res['count']>0;
	}

	public static function hasImageCode($code, $imageId) {
		$lookup = new LookupImageCodeDao();
		$sequence = Utility::hashString($code);
		$lookup->setServerAddress($sequence);

		$builder = new QueryBuilder($lookup);
		$res = $builder->select('COUNT(*) as count')
					   ->where('code', $code)
					   ->where('image_id', $imageId)
					   ->find();

		return $res['count']>0;
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