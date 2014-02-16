<?php
class ProjectDao extends ConfoneDao {

	const NAME = 'name';
	const OWNERID = 'owner_id';
	const LASTMODIFY = 'last_modify';
	const CREATETIME = 'create_time';

	const IDCOLUMN = 'id';
	const SHARDDOMAIN = '';
	const TABLE = '';

	const ACCESSLEVEL_NONE = '1000';
	const ACCESSLEVEL_ROOT = '0';
	const ACCESSLEVEL_ADMIN = '1';
	const ACCESSLEVEL_WRITE = '2';
	const ACCESSLEVEL_READ = '3';

// =============================================== public function =================================================



// ============================================ override functions ==================================================

	protected function init() {
		$this->var[ProjectDao::IDCOLUMN] = 0;
		$this->var[ProjectDao::NAME] = '';
		$this->var[ProjectDao::OWNERID] = 0;

		$date = gmdate('Y-m-d H:i:s');
		$this->var[ProjectDao::LASTMODIFY] = $date;
		$this->var[ProjectDao::CREATETIME] = $date;
	}

	protected function beforeInsert() {
		$lookup = new LookupProjectAccountDao();
		$lookup->var[LookupProjectAccountDao::ACCOUNTID] = $this->var[ProjectDao::OWNERID];
		$lookup->var[LookupProjectAccountDao::PROJECTID] = $this->var[ProjectDao::IDCOLUMN];
		$lookup->save();
	}

	public function getShardDomain() {
		return ProjectDao::SHARDDOMAIN;
	}

	public function getTableName() {
		return ProjectDao::TABLE;
	}

	public function getIdColumnName() {
		return ProjectDao::IDCOLUMN;
	}

	protected function isShardBaseObject() {
		return true;
	}
}
?>