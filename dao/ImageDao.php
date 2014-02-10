<?php
class ImageDao extends ConfoneDao {


	const IDCOLUMN = 'id';
	const SHARDDOMAIN = '';
	const TABLE = '';


// =============================================== public function =================================================



// ============================================ override functions ==================================================

	protected function init() {
		$this->var[ImageDao::IDCOLUMN] = 0;
	}

	protected function beforeInsert() {
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