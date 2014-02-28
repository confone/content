<?php
class AccountTokenDao extends ContentDao {

	const TOKEN = 'token';
	const ACCOUNTID = 'account_id';
	const TYPE = 'type';

	const IDCOLUMN = 'id';
	const SHARDDOMAIN = '';
	const TABLE = '';

	const TYPE_ACTIVATION = '0';
	const TYPE_FORGETPW = '1';

// =============================================== public function =================================================



// ============================================ override functions ==================================================

	protected function init() {
		$this->var[AccountTokenDao::TOKEN] = '';
		$this->var[AccountTokenDao::ACCOUNTID] = 0;
		$this->var[AccountTokenDao::TYPE] = 0;
		$this->var[AccountTokenDao::IDCOLUMN] = 0;
	}

	protected function beforeInsert() {
		$this->var[AccountTokenDao::TOKEN] = Utility::generateAccountToken($this->var[AccountTokenDao::ACCOUNTID]);
		$sequence = Utility::hashString($this->var[AccountTokenDao::TOKEN]);
		$this->setShardId($sequence);
	}

	public function getShardDomain() {
		return AccountTokenDao::SHARDDOMAIN;
	}

	public function getTableName() {
		return AccountTokenDao::TABLE;
	}

	public function getIdColumnName() {
		return AccountTokenDao::IDCOLUMN;
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>