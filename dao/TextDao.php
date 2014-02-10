<?php
class TextDao extends ConfoneDao {


	const IDCOLUMN = 'id';
	const SHARDDOMAIN = '';
	const TABLE = '';


// =============================================== public function =================================================



// ============================================ override functions ==================================================

	protected function init() {
		$this->var[TextDao::IDCOLUMN] = 0;
	}

	protected function beforeInsert() {
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