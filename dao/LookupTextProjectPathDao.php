<?php
class LookupTextProjectPathDao extends LookupTextProjectPathDaoParent {

// =============================================== public function =================================================

	public static function getTextIds($projectPathId) {
		$lookup = new LookupTextProjectPathDao();
		$sequence = Utility::hashString($projectPathId);
		$lookup->setShardId($sequence);

		$builder = new QueryBuilder($lookup);
		$rows = $builder->select('text_id')
						->where('project_path_id', $projectPathId)
						->findList();

		if ($rows) {
			$atReturn = array();
			foreach ($rows as $row) {
				array_push($atReturn, $row['text_id']);
			}
			return $atReturn;
		} else {
			return array();
		}
	}


// ============================================ override functions ==================================================

	protected function beforeInsert() {
		$sequence = Utility::hashString($this->getProjectPathId());
		$this->setShardId($sequence);
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>