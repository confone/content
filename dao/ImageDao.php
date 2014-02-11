<?php
class ImageDao extends ConfoneDao {

	const CODE = 'code';
	const PROJECTPATHID = 'project_path_id';
	const ACCOUNTID = 'account_id';
	const CREATETIME = 'create_time';
	const LASTMODIFY = 'last_modify';

	const IDCOLUMN = 'id';
	const SHARDDOMAIN = 'confone_image';
	const TABLE = 'image';


// =============================================== public function =================================================



// ============================================ override functions ==================================================

	protected function init() {
		$this->var[ImageDao::IDCOLUMN] = 0;
		$this->var[ImageDao::CODE] = '';
		$this->var[ImageDao::PROJECTPATHID] = 0;
		$this->var[ImageDao::ACCOUNTID] = 0;

		$date = gmdate('Y-m-d H:i:s');
		$this->var[ImageDao::CREATETIME] = $date;
		$this->var[ImageDao::LASTMODIFY] = $date;
	}

	protected function beforeInsert() {
		$lookup = new LookupImageCodeDao();
		$lookup->var[LookupImageCodeDao::CODE] = $this->var[LookupImageCodeDao::CODE];
		$lookup->var[LookupImageCodeDao::PROJECTPATHID] = $this->var[LookupImageCodeDao::PROJECTPATHID];
		$lookup->var[LookupImageCodeDao::IMAGEID] = $this->var[LookupImageCodeDao::IDCOLUMN];
		$lookup->save();
	}

	public function getShardDomain() {
		return ImageDao::SHARDDOMAIN;
	}

	public function getTableName() {
		return ImageDao::TABLE;
	}

	public function getIdColumnName() {
		return ImageDao::IDCOLUMN;
	}

	protected function isShardBaseObject() {
		return true;
	}
}
?>