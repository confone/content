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

	public static function updatePreview($imageId, $filePath) {
		$previewImageVersion = ImageVersionDao::getPreviewImage($imageId);
		$previewImageVersion->var[ImageVersionDao::FILEPATH] = $filePath;
		$previewImageVersion->save();
	}

	public static function publish($imageId) {
		$image = new ImageDao($imageId);

		if ($image->isFromDatabase()) {
			$previewImageVersion = ImageVersionDao::getPreviewImage($imageId);
			$imageVersion = new ImageVersionDao();
			$imageVersion->var = $previewImageVersion->var;

			$sql = "SELECT COUNT(*) AS count FROM ".ImageVersionDao::TABLE." WHERE "
					.ImageVersionDao::IMAGEID."=".$this->var[ImageVersionDao::IMAGEID];
			$connect = DBUtil::getConn($imageVersion);
			$res = DBUtil::selectData($connect, $sql);

			$imageVersion->var[ImageVersionDao::VERSION] = $res['count'];
			return $imageVersion->save();
		} else {
			return false;
		}
	}

	public static function getPreviewImage($imageId) {
		$imageVersion = new ImageVersionDao();
		$sequence = Utility::hashString($imageId);
		$imageVersion->setShardId($sequence);

		$sql = "SELECT * from ".ImageVersionDao::TABLE." WHERE "
				.ImageVersionDao::VERSION."=-1";

		$connect = DBUtil::getConn($imageVersion);
		$res = DBUtil::selectData($connect, $sql);

		return ConfoneDao::makeObjectFromSelectResult($res, "ImageVersionDao");
	}

	public static function getCurrentImage($imageId) {
		$imageVersion = new ImageVersionDao();
		$sequence = Utility::hashString($imageId);
		$imageVersion->setShardId($sequence);

		$sql = "SELECT * from ".ImageVersionDao::TABLE." ORDER BY "
				.ImageVersionDao::IDCOLUMN." DESC LIMIT 0, 1";

		$connect = DBUtil::getConn($imageVersion);
		$res = DBUtil::selectData($connect, $sql);

		return ConfoneDao::makeObjectFromSelectResult($res, "ImageVersionDao");
	}

	public static function getImages($imageId) {
		$imageVersion = new ImageVersionDao();
		$sequence = Utility::hashString($imageId);
		$imageVersion->setShardId($sequence);

		$sql = "SELECT * from ".ImageVersionDao::TABLE." WHERE "
				.ImageVersionDao::IMAGEID."=$imageId";

		$connect = DBUtil::getConn($imageVersion);
		$rows = DBUtil::selectDataList($connect, $sql);

		return ConfoneDao::makeObjectsFromSelectListResult($rows, "ImageVersionDao");
	}

	public static function isPreviewImagePublished($imageId) {
		$currentImage = ImageVersionDao::getCurrentImage($imageId);
		$previewImage = ImageVersionDao::getPreviewImage($imageId);

		$currentImageFilePath = $currentImage->var[ImageVersionDao::FILEPATH];
		$previewImageFilePath = $previewImage->var[ImageVersionDao::FILEPATH];

		return $currentImageFilePath == $previewImageFilePath;
	}

// ============================================ override functions ==================================================

	protected function init() {
		$this->var[ImageVersionDao::IDCOLUMN] = 0;
		$this->var[ImageVersionDao::IMAGEID] = 0;
		$this->var[ImageVersionDao::FILEPATH] = '';
		$this->var[ImageVersionDao::VERSION] = -1;
		$this->var[ImageVersionDao::CREATETIME] = '';
	}

	protected function beforeInsert() {
		$sequence = Utility::hashString($this->var[ImageVersionDao::IMAGEID]);
		$this->setShardId($sequence);
		$this->var[ImageVersionDao::CREATETIME] = gmdate('Y-m-d H:i:s');
	}

	protected function beforeUpdate() {
		$sequence = Utility::hashString($this->var[ImageVersionDao::IMAGEID]);
		$this->setShardId($sequence);
		$this->var[ImageVersionDao::CREATETIME] = gmdate('Y-m-d H:i:s');
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