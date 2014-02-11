<?php
class ProjectPathDao extends ConfoneDao {

	const PROJECTID = 'project_id';
	const PATH = 'path';
	const LASTMODIFY = 'last_modify';
	const CREATETIME = 'create_time';

	const IDCOLUMN = 'id';
	const SHARDDOMAIN = '';
	const TABLE = '';


// =============================================== public function =================================================

	public static function getProjectPath($projectId, $path) {
		$projectPath = new ProjectPathDao();
		$sequence = Utility::hashString($projectId);
		$projectPath->setShardId($sequence);

		$sql = "SELECT * FROM ".ProjectPathDao::TABLE." WHERE "
				.ProjectPathDao::PROJECTID."=$projectId AND "
				.ProjectPathDao::PATH."='$path'";

		$connect = DBUtil::getConn($lookup);
		$res = DBUtil::selectData($connect, $sql);

		return $this->makeObjectFromSelectResult($res, 'ProjectPathDao');
	}


// ============================================ override functions ==================================================

	protected function init() {
		$this->var[ProjectPathDao::IDCOLUMN] = 0;
		$this->var[ProjectPathDao::PROJECTID] = 0;
		$this->var[ProjectPathDao::PATH] = '';

		$date = gmdate('Y-m-d H:i:s');
		$this->var[ProjectPathDao::LASTMODIFY] = $date;
		$this->var[ProjectPathDao::CREATETIME] = $date;
	}

	protected function beforeInsert() {
		$sequence = Utility::hashString($this->var[ProjectPathDao::PROJECTID]);
		$this->setShardId($sequence);
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