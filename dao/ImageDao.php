<?php
class ImageDao extends ImageDaoParent {

// =============================================== public function =================================================

	public static function getAllImages($projectId, $projectPathId=0) {
		$paths = ProjectPathDao::getChildrenPath($projectId, $projectPathId);

		$atReturn = array();
		foreach ($paths as $path) {
			$ppid = $projectPathId!=0 ? $projectPathId : $projectId;
			$imageIds = LookupImageProjectPathDao::getImageIds($ppid);
			foreach ($imageIds as $imageId) {
				$image = new ImageDao($imageId);
				array_push($atReturn, $image);
			}
		}

		return $atReturn;
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

		$lookup = new LookupImageProjectPathDao();
		$lookup->setProjectId($this->getProjectId());
		$lookup->setProjectPathId($this->getProjectPathId());
		$lookup->setImageId($this->getId());
		$lookup->save();
	}

	protected function isShardBaseObject() {
		return true;
	}
}
?>