<?php
class ProjectPathDao extends ProjectPathDaoParent {

	const ROOT_PATH = '_ROOT';

// =============================================== public function =================================================

	public static function isProjectPahtExist($projectId, $parentPahtId, $path) {
		$projectPath = new ProjectPathDao();
		$sequence = $projectId;
		$projectPath->setServerAddress($sequence);

		$builder = new QueryBuilder($projectPath);
		$res = $builder->select('CONST(*) as count')
					   ->where('project_id', $projectId)
					   ->where('parent_path_id', $parentPahtId)
					   ->where('path', $path)
					   ->find();

		return $res['count']>0;
	}

	public static function getChildrenPath($projectId, $parentPathId=0) {
		$projectPath = new ProjectPathDao();
		$sequence = $projectId;
		$projectPath->setServerAddress($sequence);

		$builder = new QueryBuilder($projectPath);
		$rows = $builder->select('*')
						->where('project_id', $projectId)
						->where('parent_path_id', $parentPathId)
						->findList();

		return ContentDaoBase::makeObjectsFromSelectListResult($rows, "ProjectPathDao");
	}

	public static function getProjectPath($projectId, $pathId) {
		$projectPath = new ProjectPathDao();
		$sequence = $projectId;
		$projectPath->setServerAddress($sequence);

		$builder = new QueryBuilder($projectPath);
		$res = $builder->select('*')
					   ->where('project_id', $projectId)
					   ->where('id', $pathId)
					   ->find();

		return ContentDaoBase::makeObjectFromSelectResult($res, 'ProjectPathDao');
	}

	public static function getProjectRootPath($projectId) {
		$projectPath = new ProjectPathDao();
		$sequence = $projectId;
		$projectPath->setServerAddress($sequence);

		$builder = new QueryBuilder($projectPath);
		$res = $builder->select('*')
					   ->where('project_id', $projectId)
					   ->where('parent_path_id', 0)
					   ->where('path', self::ROOT_PATH)
					   ->find();

		return ContentDaoBase::makeObjectFromSelectResult($res, 'ProjectPathDao');
	}

	public static function getProjectPathIdByPathName($projectId, $pathName) {
		$projectPath = new ProjectPathDao();
		$sequence = $projectId;
		$projectPath->setServerAddress($sequence);

		$builder = new QueryBuilder($projectPath);
		$res = $builder->select('*')
					   ->where('project_id', $projectId)
					   ->where('path', $pathName)
					   ->find();

		return ContentDaoBase::makeObjectFromSelectResult($res, 'ProjectPathDao');
	}

	public function delete() {
		$this->setIsDeleted('Y');
		$this->save();
	}

// ============================================ override functions ==================================================

	protected function beforeInsert() {
		$date = gmdate('Y-m-d H:i:s');
		$this->setCreateTime($date);
		$this->setLastModify($date);

		$this->setIsDeleted('N');
		$parentPathId = $this->getParentPathId();
		if (empty($parentPathId)) {
			$this->setParentPathId(0);
		}

		$sequence = $this->getProjectId();
		$this->setShardId($sequence);

		if ($this->getParentPathId()!=0) {
			$parentPath = ProjectPathDao::getProjectPath($this->getProjectId(), $this->getParentPathId());
			$this->setPathFull($parentPath->getPathFull().$this->getPath().'/');
		} else {
			$this->setPathFull('/');
		}
	}

	protected function beforeUpdate() {
		$date = gmdate('Y-m-d H:i:s');
		$this->setLastModify($date);

		$sequence = $this->getProjectId();
		$this->setServerAddress($sequence);

		if ($this->update['path']) {
			if ($this->getParentPathId()!=0) {
				$parentPath = ProjectPathDao::getProjectPath($this->getProjectId(), $this->getParentPathId());
				$this->setPathFull($parentPath->getPathFull().'/'.$this->getPath());
			} else {
				$this->setPathFull('/'.$this->getPath());
			}
		}
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>