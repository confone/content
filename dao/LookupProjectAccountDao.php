<?php
class LookupProjectAccountDao extends ConfoneDao {


	const IDCOLUMN = 'id';
	const SHARDDOMAIN = '';
	const TABLE = '';


// =============================================== public function =================================================



// ============================================ override functions ==================================================

	protected function init() {
		$this->var[LookupProjectAccountDao::IDCOLUMN] = 0;
	}

	protected function beforeInsert() {
	}

	public function getShardDomain() {
		return LookupProjectAccountDao::SHARDDOMAIN;
	}

	public function getTableName() {
		return LookupProjectAccountDao::TABLE;
	}

	public function getIdColumnName() {
		return LookupProjectAccountDao::IDCOLUMN;
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>