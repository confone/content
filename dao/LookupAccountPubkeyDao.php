<?php
class LookupAccountPubkeyDao extends ContentDao {

	const PUBKEY = 'pubkey';
	const ACCOUNTID = 'account_id';

	const IDCOLUMN = 'id';
	const SHARDDOMAIN = 'confone_lookup_account';
	const TABLE = 'account_pubkey';

// ============================================ override functions ==================================================

	public static function getUserIdByPublicKey($pubkey) {
		$lookup = new LookupAccountPubkeyDao();
		$lookup->setServerAddress( Utility::hashString($pubkey) );

		$sql = "SELECT ".LookupAccountPubkeyDao::ACCOUNTID." FROM ".LookupAccountPubkeyDao::TABLE." WHERE "
				.LookupAccountPubkeyDao::PUBKEY."='$pubkey'";

		$connect = DBUtil::getConn($lookup);
		$res = DBUtil::selectData($connect, $sql);

		if ($res) {
			return $res[LookupAccountPubkeyDao::ACCOUNTID];
		} else {
			return 0;
		}
	}

// ============================================ override functions ==================================================

	protected function init() {
		$this->var[LookupAccountPubkeyDao::PUBKEY] = '';
		$this->var[LookupAccountPubkeyDao::ACCOUNTID] = '';
	}

	protected function beforeInsert() {
		$sequence = Utility::hashString($this->var[AccountDao::PUBKEY]);
		$this->setShardId($sequence);
	}

	public function getShardDomain() {
		return LookupAccountPubkeyDao::SHARDDOMAIN;
	}

	public function getTableName() {
		return LookupAccountPubkeyDao::TABLE;
	}

	public function getIdColumnName() {
		return LookupAccountPubkeyDao::IDCOLUMN;
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>