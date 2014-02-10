<?php
class ImageVersionDao extends ConfoneDao {


	const IDCOLUMN = 'id';
	const SHARDDOMAIN = '';
	const TABLE = '';


// =============================================== public function =================================================



// ============================================ override functions ==================================================

	protected function init() {
		$this->var[ImageVersionDao::IDCOLUMN] = 0;
	}

	protected function beforeInsert() {
	}

	public function getShardDomain() {
		return ImageVersionDao::SHARDDOMAIN;
	}

	public function getTableName() {
		return ImageVersionDao::TABLE;
	}

	public function getIdColumnName() {
		return ImageVersionDao::IDCOLUMN;
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>