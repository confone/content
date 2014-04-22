<?php
class ImageDao extends ImageDaoParent {

// =============================================== public function =================================================

	public static function getImages($projectId, $projectPathId) {
		$images = array();

		$ids = LookupImageProjectPathDao::getImageIds($projectId, $projectPathId);

		foreach ($ids as $id) {
			array_push($images, new ImageDao($id));
		}

		return $images;
	}

	public static function getImageByCode($code, $projectId) {
		$imageId = LookupImageCodeDao::lookupImageId($code, $projectId);

		$imageDao = new ImageDao($imageId);

		return $imageDao;
	}

// ============================================ override functions ==================================================

	protected function beforeInsert() {
		$lookup = new LookupImageCodeDao();
		$lookup->setCode($this->getCode());
		$lookup->setImageId($this->getId());
		$lookup->setProjectId($this->getProjectId());
		$lookup->save();
	}

	protected function isShardBaseObject() {
		return true;
	}
}
?>