<?php
class LookupTextCodeDao extends ConfoneDao {


	const IDCOLUMN = 'id';
	const SHARDDOMAIN = '';
	const TABLE = '';


// =============================================== public function =================================================



// ============================================ override functions ==================================================

	protected function init() {
		$this->var[LookupTextCodeDao::IDCOLUMN] = 0;
	}

	protected function beforeInsert() {
	}

	public function getShardDomain() {
		return LookupTextCodeDao::SHARDDOMAIN;
	}

	public function getTableName() {
		return LookupTextCodeDao::TABLE;
	}

	public function getIdColumnName() {
		return LookupTextCodeDao::IDCOLUMN;
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>