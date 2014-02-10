<?php
class TokenDao extends ConfoneDao {


	const IDCOLUMN = 'id';
	const SHARDDOMAIN = '';
	const TABLE = '';


// =============================================== public function =================================================



// ============================================ override functions ==================================================

	protected function init() {
		$this->var[TokenDao::IDCOLUMN] = 0;
	}

	protected function beforeInsert() {
	}

	public function getShardDomain() {
		return TokenDao::SHARDDOMAIN;
	}

	public function getTableName() {
		return TokenDao::TABLE;
	}

	public function getIdColumnName() {
		return TokenDao::IDCOLUMN;
	}

	protected function isShardBaseObject() {
		return true;
	}
}
?>