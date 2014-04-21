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

	public static function getImagesByCode($code, $projectId) {
		$imageIds = LookupImageCodeDao::getImageId($code, $projectId);

		$atReturn = array();
		foreach ($imageIds as $imageId) {
			$image = new ImageDao($imageId);
			array_push($atReturn, $image);
		}

		return $atReturn;
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