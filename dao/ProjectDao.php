<?php
class ProjectDao extends ConfoneDao {


	const IDCOLUMN = 'id';
	const SHARDDOMAIN = '';
	const TABLE = '';


// =============================================== public function =================================================



// ============================================ override functions ==================================================

	protected function init() {
		$this->var[ProjectDao::IDCOLUMN] = 0;
	}

	protected function beforeInsert() {
	}

	public function getShardDomain() {
		return ProjectDao::SHARDDOMAIN;
	}

	public function getTableName() {
		return ProjectDao::TABLE;
	}

	public function getIdColumnName() {
		return ProjectDao::IDCOLUMN;
	}

	protected function isShardBaseObject() {
		return true;
	}
}
?>