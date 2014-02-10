<?php
class LookupImageCodeDao extends ConfoneDao {


	const IDCOLUMN = 'id';
	const SHARDDOMAIN = '';
	const TABLE = '';


// =============================================== public function =================================================



// ============================================ override functions ==================================================

	protected function init() {
		$this->var[LookupImageCodeDao::IDCOLUMN] = 0;
	}

	protected function beforeInsert() {
	}

	public function getShardDomain() {
		return LookupImageCodeDao::SHARDDOMAIN;
	}

	public function getTableName() {
		return LookupImageCodeDao::TABLE;
	}

	public function getIdColumnName() {
		return LookupImageCodeDao::IDCOLUMN;
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>