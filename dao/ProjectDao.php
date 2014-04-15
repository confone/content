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
		$date = gmdate('Y-m-d H:i:s');
		$this->setCreateTime($date);
		$this->setLastModify($date);

		$lookup = new LookupProjectAccountDao();
		$lookup->setAccountId($this->getOwnerId());
		$lookup->setProjectId($this->getId());
		$lookup->save();
	}

	protected function isShardBaseObject() {
		return true;
	}
}
?>