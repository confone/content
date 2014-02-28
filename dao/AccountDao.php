<?php
class AccountDao extends ContentDao {

	const EMAIL = 'email';
	const PASSWORD = 'password';
	const NAME = 'name';
	const PROFILEPIC = 'profile_pic';
	const DESCRIPTION = 'description';
	const LASTLOGIN = 'last_login';
	const PUBLICKEY = 'public_key';
	const PRIVATEKEY = 'private_key';
	const LEVEL = 'level';
	const BLOCKED = 'blocked';

	const IDCOLUMN = 'id';
	const SHARDDOMAIN = 'confone_account';
	const TABLE = 'account';

	const LEVEL_COMMUNITY = '0';
	const LEVEL_BUSINESS = '1';
	const LEVEL_ENTERPRISE = '2';
	const LEVEL_PREMIUM = '3';
	const LEVEL_DEMAND = '4';

// =============================================== public function =================================================

	public static function authenticate($email, $passwd) {
		$account = AccountDao::getAccountByEmail($email);

		$atReturn = null;
		if (isset($account) && $account->var[AccountDao::PASSWORD]==md5($passwd)) {
			$atReturn = $account;
		}

		return $atReturn;
	}

	public static function getAccountByEmail($email) {
		$accountId = LookupAccountEmailDao::getUserIdByEmail($email);

		$account = null;
		if ($accountId!=0) {
			$account = new AccountDao($accountId);
		}

		return $account;
	}

	public static function getAccountByPublicKey($pubkey) {
		$accountId = LookupAccountPubkeyDao::getUserIdByPublicKey($pubkey);

		$account = null;
		if ($accountId!=0) {
			$account = new AccountDao($accountId);
		}

		return $account;
	}

	public static function canViewProjectContent($accountId, $projectId) {
		$accessLevel =  LookupProjectAccountDao::getAccessLevel($projectId, $accountId);
		return $accessLevel <= ProjectDao::ACCESSLEVEL_READ;
	}

	public static function canModifyProjectContent($accountId, $projectId) {
		$accessLevel =  LookupProjectAccountDao::getAccessLevel($projectId, $accountId);
		return $accessLevel <= ProjectDao::ACCESSLEVEL_WRITE;
	}

	public static function canModifyProjectUser($accountId, $projectId) {
		$accessLevel =  LookupProjectAccountDao::getAccessLevel($projectId, $accountId);
		return $accessLevel <= ProjectDao::ACCESSLEVEL_ADMIN;
	}

	public static function canModifyProjectAdmin($accountId, $projectId) {
		$accessLevel =  LookupProjectAccountDao::getAccessLevel($projectId, $accountId);
		return $accessLevel <= ProjectDao::ACCESSLEVEL_ROOT;
	}

	public function isBlocked() {
		return $this->var[AccountDao::BLOCKED] == 'Y';
	}

// ============================================ override functions ==================================================

	protected function init() {
		global $base_host;
		$this->var[AccountDao::EMAIL] = 0;
		$this->var[AccountDao::PASSWORD] = '';
		$this->var[AccountDao::NAME] = '';
		$this->var[AccountDao::PROFILEPIC] = $base_host.'/portal/img/default_profile.png';
		$this->var[AccountDao::DESCRIPTION] = '';
		$this->var[AccountDao::LASTLOGIN] = gmdate('Y-m-d H:i:s');
		$this->var[AccountDao::PUBLICKEY] = '';
		$this->var[AccountDao::PRIVATEKEY] = '';
		$this->var[AccountDao::LEVEL] = AccountDao::LEVEL_COMMUNITY;
		$this->var[AccountDao::BLOCKED] = 'Y';
	}

	protected function beforeInsert() {
		$this->var[AccountDao::PUBLICKEY] = 'pub_key_'.$this->var[AccountDao::IDCOLUMN].'_'.$this->publicKeyGen();
		$this->var[AccountDao::PRIVATEKEY] = 'pri_key_'.$this->var[AccountDao::IDCOLUMN].'_'.$this->privateKeyGen();

		$lookup = new LookupAccountEmailDao();
		$lookup->var[LookupAccountEmailDao::EMAIL] = $this->var[AccountDao::EMAIL];
		$lookup->var[LookupAccountEmailDao::ACCOUNTID] = $this->var[AccountDao::IDCOLUMN];
		$lookup->save();

		$lookup = new LookupAccountPubkeyDao();
		$lookup->var[LookupAccountPubkeyDao::PUBKEY] = $this->var[AccountDao::PUBLICKEY];
		$lookup->var[LookupAccountPubkeyDao::ACCOUNTID] = $this->var[AccountDao::IDCOLUMN];
		$lookup->save();
	}

	public function getShardDomain() {
		return AccountDao::SHARDDOMAIN;
	}

	public function getTableName() {
		return AccountDao::TABLE;
	}

	public function getIdColumnName() {
		return AccountDao::IDCOLUMN;
	}

	protected function isShardBaseObject() {
		return true;
	}

	private function publicKeyGen() {
		$token = md5(microtime());
		return substr($token, 0, 20);
	}

	private function privateKeyGen() {
		$token = md5(rand());
		return substr($token, rand(0, 10), 20);
	}
}
?>