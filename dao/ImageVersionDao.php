<?php
class ImageVersionDao extends ConfoneDao {

	const IMAGEID = 'image_id';
	const FILEPATH = 'file_path';
	const VERSION = 'version';
	const CREATETIME = 'create_time';

	const IDCOLUMN = 'id';
	const SHARDDOMAIN = 'confone_image';
	const TABLE = 'image_version';


// =============================================== public function =================================================



// ============================================ override functions ==================================================

	protected function init() {
		$this->var[ImageVersionDao::IDCOLUMN] = 0;
		$this->var[ImageVersionDao::IMAGEID] = 0;
		$this->var[ImageVersionDao::FILEPATH] = '';
		$this->var[ImageVersionDao::VERSION] = -1;
		$this->var[ImageVersionDao::CREATETIME] = gmdate('Y-m-d H:i:s');
	}

	protected function beforeInsert() {
		$sequence = Utility::hashString($this->var[ImageVersionDao::IMAGEID]);
		$this->setShardId($sequence);

		$sql = "UPDATE ".ImageVersionDao::TABLE." SET "
				.ImageVersionDao::VERSION."=".ImageVersionDao::VERSION."+1 WHERE "
				.ImageVersionDao::IMAGEID."=".$this->var[ImageVersionDao::IMAGEID];

		$connect = DBUtil::getConn($this);
		DBUtil::updateData($connect, $sql);
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