<?php
class ImageDao extends ContentDao {

	const CODE = 'code';
	const PROJECTID = 'project_id';
	const PROJECTPATHID = 'project_path_id';
	const ACCOUNTID = 'account_id';
	const CREATETIME = 'create_time';
	const LASTMODIFY = 'last_modify';

	const IDCOLUMN = 'id';
	const SHARDDOMAIN = 'confone_image';
	const TABLE = 'image';


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

	protected function init() {
		$this->var[ImageDao::IDCOLUMN] = 0;
		$this->var[ImageDao::CODE] = '';
		$this->var[ImageDao::PROJECTID] = 0;
		$this->var[ImageDao::PROJECTPATHID] = 0;
		$this->var[ImageDao::ACCOUNTID] = 0;

		$date = gmdate('Y-m-d H:i:s');
		$this->var[ImageDao::CREATETIME] = $date;
		$this->var[ImageDao::LASTMODIFY] = $date;
	}

	protected function beforeInsert() {
		$lookup = new LookupImageCodeDao();
		$lookup->var[LookupImageCodeDao::CODE] = $this->var[ImageDao::CODE];
		$lookup->var[LookupImageCodeDao::IMAGEID] = $this->var[ImageDao::IDCOLUMN];
		$lookup->var[LookupImageCodeDao::PROJECTID] = $this->var[ImageDao::PROJECTID];
		$lookup->save();

		$projectPathId = $this->var[ImageDao::PROJECTPATHID];
		$projectId = $this->var[ImageDao::PROJECTID];

		$lookup = new LookupImageProjectPathDao();
		$lookup->var[LookupImageProjectPathDao::PROJECTPATHID] = $projectPathId!=0 ? $projectPathId : $projectId;
		$lookup->var[LookupImageProjectPathDao::IMAGEID] = $this->var[ImageDao::IDCOLUMN];
		$lookup->save();
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