<?php
class TextVersionDao extends ConfoneDao {


	const IDCOLUMN = 'id';
	const SHARDDOMAIN = '';
	const TABLE = '';


// =============================================== public function =================================================



// ============================================ override functions ==================================================

	protected function init() {
		$this->var[TextVersionDao::IDCOLUMN] = 0;
	}

	protected function beforeInsert() {
	}

	public function getShardDomain() {
		return TextVersionDao::SHARDDOMAIN;
	}

	public function getTableName() {
		return TextVersionDao::TABLE;
	}

	public function getIdColumnName() {
		return TextVersionDao::IDCOLUMN;
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>