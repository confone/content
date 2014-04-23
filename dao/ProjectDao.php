<?php
class ProjectDao extends ProjectDaoParent {

	const ACCESSLEVEL_NONE = '1000';
	const ACCESSLEVEL_ROOT = '0';
	const ACCESSLEVEL_ADMIN = '1';
	const ACCESSLEVEL_WRITE = '2';
	const ACCESSLEVEL_READ = '3';

// =============================================== public function =================================================



// ============================================ override functions ==================================================

	protected function beforeInsert() {
		$publicKey = 'pub_'.Utility::generateToken('_'.$this->getOwnerId().'_'.rand(0, 100).'_');
		$privateKey = 'pri_'.Utility::generateToken('_'.$this->getOwnerId().'_'.rand(0, 100).'_');

		$date = gmdate('Y-m-d H:i:s');
		$this->setCreateTime($date);
		$this->setLastModify($date);
		$this->setPublicKey($publicKey);
		$this->setPrivateKey($privateKey);

		$lookup = new LookupProjectAccountDao();
		$lookup->setAccountId($this->getOwnerId());
		$lookup->setProjectId($this->getId());
		$lookup->save();

		$lookup = new LookupPubkeyProjectDao();
		$lookup->setPubKey($publicKey);
		$lookup->setProjectId($this->getId());
		$lookup->save();

		$lookup = new LookupPrikeyProjectDao();
		$lookup->setPriKey($privateKey);
		$lookup->setProjectId($this->getId());
		$lookup->save();
	}

	protected function isShardBaseObject() {
		return true;
	}
}
?>