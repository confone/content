<?php
class ProjectPathDao extends ContentDao {

	const PROJECTID = 'project_id';
	const PARENTPATHID = 'parent_path_id';
	const PATH = 'path';
	const PATHFULL = 'path_full';
	const LASTMODIFY = 'last_modify';
	const CREATETIME = 'create_time';

	const IDCOLUMN = 'id';
	const SHARDDOMAIN = '';
	const TABLE = '';


// =============================================== public function =================================================

	public static function isProjectPahtExist($projectId, $parentPahtId, $path) {
		$projectPath = new ProjectPathDao();
		$sequence = Utility::hashString($projectId);
		$projectPath->setShardId($sequence);

		$sql = "SELECT CONST(*) as count FROM ".ProjectPathDao::TABLE." WHERE "
				.ProjectPathDao::PROJECTID."=$projectId AND "
				.ProjectPathDao::PARENTPATHID."$parentPahtId AND "
				.ProjectPathDao::PATH."='$path'";

		$connect = DBUtil::getConn($projectPath);
		$res = DBUtil::selectData($connect, $sql);

		return $res['count']>0;
	}

	public static function getChildrenPath($projectId, $pathId=0) {
		$projectPath = new ProjectPathDao();
		$sequence = Utility::hashString($projectId);
		$projectPath->setShardId($sequence);

		$sql = "SELECT * FROM ".ProjectPathDao::TABLE." WHERE "
				.ProjectPathDao::PROJECTID."=$projectId AND "
				.ProjectPathDao::PARENTPATHID."=$pathId";

		$connect = DBUtil::getConn($projectPath);
		$rows = DBUtil::selectDataList($connect, $sql);

		return ContentDao::makeObjectsFromSelectListResult($rows, "ProjectPathDao");
	}

	public static function getProjectPath($projectId, $pathId) {
		$projectPath = new ProjectPathDao();
		$sequence = Utility::hashString($projectId);
		$projectPath->setShardId($sequence);

		$sql = "SELECT * FROM ".ProjectPathDao::TABLE." WHERE "
				.ProjectPathDao::PROJECTID."=$projectId AND "
				.ProjectPathDao::IDCOLUMN."=$pathId";

		$connect = DBUtil::getConn($projectPath);
		$res = DBUtil::selectData($connect, $sql);

		return ContentDao::makeObjectFromSelectResult($res, 'ProjectPathDao');
	}

// ============================================ override functions ==================================================

	protected function init() {
		$this->var[ProjectPathDao::IDCOLUMN] = 0;
		$this->var[ProjectPathDao::PROJECTID] = 0;
		$this->var[ProjectPathDao::PARENTPATHID] = 0;
		$this->var[ProjectPathDao::PATH] = '';
		$this->var[ProjectPathDao::PATHFULL] = '';

		$date = gmdate('Y-m-d H:i:s');
		$this->var[ProjectPathDao::LASTMODIFY] = $date;
		$this->var[ProjectPathDao::CREATETIME] = $date;
	}

	protected function beforeInsert() {
		$sequence = Utility::hashString($this->var[ProjectPathDao::PROJECTID]);
		$this->setShardId($sequence);

		if ($this->var[ProjectPathDao::PARENTPATHID]!=0) {
			$parentPath = ProjectPathDao::getProjectPath (
				$this->var[ProjectPathDao::PROJECTID], $this->var[ProjectPathDao::PARENTPATHID] );
		}

		if (isset($parentPath)) {
			$this->var[ProjectPathDao::PATHFULL] 
				= $parentPath->var[ProjectPathDao::PATHFULL].'/'.$this->var[ProjectPathDao::PATH];
		} else {
			$this->var[ProjectPathDao::PATHFULL] = '/'.$this->var[ProjectPathDao::PATH];
		}
	}

	protected function beforeUpdate() {
		$sequence = Utility::hashString($this->var[ProjectPathDao::PROJECTID]);
		$this->setShardId($sequence);

		if ($this->var[ProjectPathDao::PARENTPATHID]!=0) {
			$parentPath = ProjectPathDao::getProjectPath (
				$this->var[ProjectPathDao::PROJECTID], $this->var[ProjectPathDao::PARENTPATHID] );
		}

		if (isset($parentPath)) {
			$this->var[ProjectPathDao::PATHFULL] 
				= $parentPath->var[ProjectPathDao::PATHFULL].'/'.$this->var[ProjectPathDao::PATH];
		} else {
			$this->var[ProjectPathDao::PATHFULL] = '/'.$this->var[ProjectPathDao::PATH];
		}
	}

	public function getShardDomain() {
		return ProjectPathDao::SHARDDOMAIN;
	}

	public function getTableName() {
		return ProjectPathDao::TABLE;
	}

	public function getIdColumnName() {
		return ProjectPathDao::IDCOLUMN;
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>