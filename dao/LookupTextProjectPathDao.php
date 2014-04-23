<?php
class LookupTextProjectPathDao extends LookupTextProjectPathDaoParent {

// =============================================== public function =================================================

	public static function getTextIds($projectId, $projectPathId) {
		$lookup = new LookupTextProjectPathDao();
		$sequence = $projectId;
		$lookup->setServerAddress($sequence);

		$builder = new QueryBuilder($lookup);
		$rows = $builder->select('text_id')
						->where('project_id', $projectId)
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

	public static function getTextIdsAndCodes($projectId, $projectPathId) {
		$lookup = new LookupTextProjectPathDao();
		$sequence = $projectId;
		$lookup->setServerAddress($sequence);

		$builder = new QueryBuilder($lookup);
		$rows = $builder->select('text_id, code')
						->where('project_id', $projectId)
						->where('project_path_id', $projectPathId)
						->findList();

		if ($rows) {
			$atReturn = array();
			foreach ($rows as $row) {
				array_push($atReturn, $row);
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

	protected function beforeUpdate() {
		$sequence = $this->getProjectId();
		$this->setServerAddress($sequence);
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>