<?php
class ProjectPathDao extends ConfoneDao {


	const IDCOLUMN = 'id';
	const SHARDDOMAIN = '';
	const TABLE = '';


// =============================================== public function =================================================



// ============================================ override functions ==================================================

	protected function init() {
		$this->var[ProjectPathDao::IDCOLUMN] = 0;
	}

	protected function beforeInsert() {
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