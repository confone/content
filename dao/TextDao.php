<?php
class TextDao extends ConfoneDao {

	const CODE = 'code';
	const PROJECTPATHID = 'project_path_id';
	const ACCOUNTID = 'account_id';
	const CREATETIME = 'create_time';
	const LASTMODIFY = 'last_modify';

	const IDCOLUMN = 'id';
	const SHARDDOMAIN = 'confone_text';
	const TABLE = 'text';


// =============================================== public function =================================================



// ============================================ override functions ==================================================

	protected function init() {
		$this->var[TextDao::IDCOLUMN] = 0;
		$this->var[TextDao::CODE] = '';
		$this->var[TextDao::PROJECTPATHID] = 0;
		$this->var[TextDao::ACCOUNTID] = 0;

		$date = gmdate('Y-m-d H:i:s');
		$this->var[TextDao::CREATETIME] = $date;
		$this->var[TextDao::LASTMODIFY] = $date;
	}

	protected function beforeInsert() {
		$lookup = new LookupTextCodeDao();
		$lookup->var[LookupTextCodeDao::CODE] = $this->var[LookupTextCodeDao::CODE];
		$lookup->var[LookupTextCodeDao::PROJECTPATHID] = $this->var[LookupTextCodeDao::PROJECTPATHID];
		$lookup->var[LookupTextCodeDao::IMAGEID] = $this->var[LookupTextCodeDao::IDCOLUMN];
		$lookup->save();
	}

	public function getShardDomain() {
		return TextDao::SHARDDOMAIN;
	}

	public function getTableName() {
		return TextDao::TABLE;
	}

	public function getIdColumnName() {
		return TextDao::IDCOLUMN;
	}

	protected function isShardBaseObject() {
		return true;
	}
}
?>