<?php
class ProjectPathDao extends ProjectPathDaoParent {

// =============================================== public function =================================================

	public static function isProjectPahtExist($projectId, $parentPahtId, $path) {
		$projectPath = new ProjectPathDao();
		$sequence = $projectId;
		$projectPath->setShardId($sequence);

		$builder = new QueryBuilder($projectPath);
		$res = $builder->select('CONST(*) as count')
					   ->where('project_id', $projectId)
					   ->where('parent_path_id', $parentPahtId)
					   ->where('path', $path)
					   ->find();

		return $res['count']>0;
	}

	public static function getChildrenPath($projectId, $pathId=0) {
		$projectPath = new ProjectPathDao();
		$sequence = $projectId;
		$projectPath->setShardId($sequence);

		$builder = new QueryBuilder($projectPath);
		$rows = $builder->select('*')
						->where('project_id', $projectId)
						->where('parent_path_id', $pathId)
						->findList();

		return ContentDaoBase::makeObjectsFromSelectListResult($rows, "ProjectPathDao");
	}

	public static function getProjectPath($projectId, $pathId) {
		$projectPath = new ProjectPathDao();
		$sequence = $projectId;
		$projectPath->setShardId($sequence);

		$builder = new QueryBuilder($projectPath);
		$res = $builder->select('*')
					   ->where('project_id', $projectId)
					   ->where('id', $pathId)
					   ->find();

		return ContentDaoBase::makeObjectFromSelectResult($res, 'ProjectPathDao');
	}

// ============================================ override functions ==================================================

	protected function beforeInsert() {
		$date = gmdate('Y-m-d H:i:s');
		$this->setCreateTime($date);
		$this->setLastModify($date);

		$sequence = $this->getProjectId();
		$this->setShardId($sequence);

		if ($this->getParentPathId()!=0) {
			$parentPath = ProjectPathDao::getProjectPath($this->getProjectId(), $this->getParentPathId());
		}

		if (isset($parentPath)) {
			$this->setPathFull($parentPath->getPathFull().'/'.$this->getPath());
		} else {
			$this->setPathFull('/'.$this->getPath());
		}
	}

	protected function beforeUpdate() {
		$date = gmdate('Y-m-d H:i:s');
		$this->setLastModify($date);

		$sequence = $this->getProjectId();
		$this->setShardId($sequence);
	
		if ($this->getParentPathId()!=0) {
			$parentPath = ProjectPathDao::getProjectPath($this->getProjectId(), $this->getParentPathId());
		}

		if (isset($parentPath)) {
			$this->setPathFull($parentPath->getPathFull().'/'.$this->getPath());
		} else {
			$this->setPathFull('/'.$this->getPath());
		}
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>