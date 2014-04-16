<?php
class ProjectPath extends Model {

	private $dao = null;

	private $images = array();

	private $texts = array();

	private $subProjectPaths = array();

	protected function init() {
		$this->dao = new ProjectPathDao($this->getId());
	}
	public function persist() {
		$this->dao->save();
	}

	public function remove() {
		$this->getDao()->delete();
	}

	public function addImage($userId, $code) {
		$image = new ImageDao();
		$image->setAccountId($userId);
		$image->setCode($code);
		$image->setProjectId($this->dao->getProjectId());
		$image->setProjectPathId($this->getId());
		$image->save();

		if (!empty($this->images)) {
			$this->images[$image->getId()] = new Image($image->getId());
		}
	}

	public function getImages() {
		if (empty($this->images)) {
			$ids = LookupImageProjectPathDao::getImageIds($this->dao->getProjectId(), $this->getId());
			foreach ($ids as $id) {
				$this->images[$id] = new Image($id);
			}
		}

		return $this->images;
	}

	public function addText($userId, $code) {
		$text = new TextDao();
		$text->setAccountId($userId);
		$text->setCode($code);
		$text->setProjectId($this->dao->getProjectId());
		$text->setProjectPathId($this->getId());
		$text->save();

		if (!empty($this->texts)) {
			$this->texts[$text->getId()] = new Text($text->getId());
		}
	}

	public function getTexts() {
		if (empty($this->texts)) {
			$ids = LookupTextProjectPathDao::getTextIds($this->dao->getProjectId(), $this->getId());
			foreach ($ids as $id) {
				$this->texts[$id] = new Text($id);
			}
		}

		return $this->texts;
	}

	public function addSubProjectPath($path) {
		$pathDao = new ProjectPathDao();
		$pathDao->setPath($path);
		$pathDao->setProjectId($this->dao->getProjectId());
		$pathDao->setParentPathId($this->getId());
		$pathDao->save();

		if (!empty($this->subProjectPaths)) {
			$this->subProjectPaths[$pathDao->getId()] = new ProjectPath($pathDao->getid());
		}
	}

	public function getSubProjectPaths() {
		if (empty($this->subProjectPaths)) {
			$daos = ProjectPathDao::getChildrenPath($this->dao->getProjectId(), $this->getId());
			foreach ($daos as $dao) {
				$this->subProjectPaths[$dao->getId()] = new ProjectPath($dao->getId());
			}
		}

		return $this->subProjectPaths;
	}
}
?>