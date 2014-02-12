<?php
class PubkeyTokenDao extends ConfoneDao {

	const TOKEN = 'token';
	const PUBKEY = 'pubkey';

	const IDCOLUMN = 'id';
	const SHARDDOMAIN = '';
	const TABLE = '';

	const TYPE_ACTIVATION = '0';
	const TYPE_FORGETPW = '1';

// =============================================== public function =================================================



// ============================================ override functions ==================================================

	protected function init() {
		$this->var[PubkeyTokenDao::IDCOLUMN] = 0;
		$this->var[PubkeyTokenDao::TOKEN] = '';
		$this->var[PubkeyTokenDao::PUBKEY] = '';
	}

	protected function beforeInsert() {
		$this->var[PubkeyTokenDao::TOKEN] = Utility::generateAccountToken(rand(1, 99999999));
		$sequence = Utility::hashString($this->var[PubkeyTokenDao::TOKEN]);
		$this->setShardId($sequence);
	}

	public function getShardDomain() {
		return PubkeyTokenDao::SHARDDOMAIN;
	}

	public function getTableName() {
		return PubkeyTokenDao::TABLE;
	}

	public function getIdColumnName() {
		return PubkeyTokenDao::IDCOLUMN;
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>