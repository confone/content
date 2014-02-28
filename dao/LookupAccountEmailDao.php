<?php
class LookupAccountEmailDao extends ContentDao {

	const EMAIL = 'email';
	const ACCOUNTID = 'account_id';

	const IDCOLUMN = 'id';
	const SHARDDOMAIN = 'confone_lookup_account';
	const TABLE = 'account_email';

// ============================================ override functions ==================================================

	public static function getUserIdByEmail($email) {
		$lookup = new LookupAccountEmailDao();
		$lookup->setServerAddress( Utility::hashString($email) );

		$sql = "SELECT ".LookupAccountEmailDao::ACCOUNTID." FROM ".LookupAccountEmailDao::TABLE." WHERE "
				.LookupAccountEmailDao::EMAIL."='$email'";

		$connect = DBUtil::getConn($lookup);
		$res = DBUtil::selectData($connect, $sql);

		if ($res) {
			return $res[LookupAccountEmailDao::ACCOUNTID];
		} else {
			return 0;
		}
	}

// ============================================ override functions ==================================================

	protected function init() {
		$this->var[LookupAccountEmailDao::EMAIL] = '';
		$this->var[LookupAccountEmailDao::ACCOUNTID] = '';
	}

	protected function beforeInsert() {
		$sequence = Utility::hashString($this->var[AccountDao::EMAIL]);
		$this->setShardId($sequence);
	}

	public function getShardDomain() {
		return LookupAccountEmailDao::SHARDDOMAIN;
	}

	public function getTableName() {
		return LookupAccountEmailDao::TABLE;
	}

	public function getIdColumnName() {
		return LookupAccountEmailDao::IDCOLUMN;
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>