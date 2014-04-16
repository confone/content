<?php
class LookupImageProjectPathDao extends LookupImageProjectPathDaoParent {

// =============================================== public function =================================================

	public static function getImageIds($projectId, $projectPathId) {
		$lookup = new LookupImageProjectPathDao();
		$sequence = $projectId;
		$lookup->setShardId($sequence);

		$builder = new QueryBuilder($lookup);
		$rows = $builder->select('image_id')
						->where('project_id', $projectId)
						->where('project_path_id', $projectPathId)
						->findList();

		if ($rows) {
			$atReturn = array();
			foreach ($rows as $row) {
				array_push($atReturn, $row['image_id']);
			}
			return $atReturn;
		} else {
			return array();
		}
	}

// ============================================ override functions ==================================================

	protected function beforeInsert() {
		$sequence = $this->getProjectId();
		$this->setShardId($sequence);
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>