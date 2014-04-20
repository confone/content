<?php
class ImageVersionDao extends ImageVersionDaoParent {

	const PREVIEW_VERSION = -1;

// =============================================== public function =================================================

	public static function updatePreview($imageId, $filePath) {
		$previewImageVersion = ImageVersionDao::getPreviewImage($imageId);
		$previewImageVersion->setFilePath($filePath);
		$previewImageVersion->save();
	}

	public static function publish($imageId) {
		$image = new ImageDao($imageId);

		if ($image->isFromDatabase()) {
			$previewImageVersion = ImageVersionDao::getPreviewImage($imageId);
			if (isset($previewImageVersion)) {
				$imageVersion = new ImageVersionDao();
				$imageVersion->var = $previewImageVersion->var;
	
				$builder = new QueryBuilder($imageVersion);
				$res = $builder->select('COUNT(*) AS count')
							   ->where('image_id', $this->getImageId())
							   ->find();
	
				$imageVersion->setVersion($res['count']);
				return $imageVersion->save();
			} else {
				return true;
			}
		} else {
			return false;
		}
	}

	public static function getPreviewImage($imageId) {
		$imageVersion = new ImageVersionDao();
		$sequence = $imageId;
		$imageVersion->setShardId($sequence);

		$builder = new QueryBuilder($imageVersion);
		$res = $builder->select('*')
					   ->where('image_id', $imageId)
					   ->where('version', self::PREVIEW_VERSION)
					   ->find();

		return ContentDaoBase::makeObjectFromSelectResult($res, "ImageVersionDao");
	}

	public static function getCurrentImage($imageId) {
		$imageVersion = new ImageVersionDao();
		$sequence = $imageId;
		$imageVersion->setShardId($sequence);

		$builder = new QueryBuilder($imageVersion);
		$res = $builder->select('*')
					   ->where('image_id', $imageId)
					   ->order('id', true)
					   ->limit(0, 1)
					   ->find();

		return ContentDaoBase::makeObjectFromSelectResult($res, "ImageVersionDao");
	}

	public static function getImages($imageId) {
		$imageVersion = new ImageVersionDao();
		$sequence = $imageId;
		$imageVersion->setShardId($sequence);

		$builder = new QueryBuilder($imageVersion);
		$rows = $builder->select('*')
						->where('image_id', $imageId)
						->findList();

		return ContentDaoBase::makeObjectsFromSelectListResult($rows, "ImageVersionDao");
	}

	public static function isPreviewImagePublished($imageId) {
		$currentImage = ImageVersionDao::getCurrentImage($imageId);
		$previewImage = ImageVersionDao::getPreviewImage($imageId);

		$currentImageFilePath = $currentImage->getFilePath();
		$previewImageFilePath = $previewImage->getFilePath();

		return $currentImageFilePath == $previewImageFilePath;
	}

// ============================================ override functions ==================================================

	protected function doDelete() {
		$builder = new QueryBuilder($this);
		$builder->delete()->where('id', $this->getId())->query();
	}

	protected function beforeInsert() {
		$sequence = $this->getImageId();
		$this->setShardId($sequence);
		$this->setCreateTime(gmdate('Y-m-d H:i:s'));
		$this->setVersion(self::PREVIEW_VERSION);

		$previewDao = self::getPreviewImage($this->getImageId());
		if (isset($previewDao)) { $previewDao->delete(); }
	}

	protected function beforeUpdate() {
		$this->setCreateTime(gmdate('Y-m-d H:i:s'));
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>