<?php
class ProjectPath extends Model {

	private $images = array();

	private $texts = array();

	private $subProjectPaths = array();

	public function remove() {
		$this->getDao()->delete();
	}

	public function getImages() {
		if (empty($this->images)) {
			$ids = LookupImageProjectPathDao::getImageIds($this->dao->getProjectId(), $this->getId());
			foreach ($ids as $id) {
				$image = new ImageDao($id);
				$this->images[$id] = new Image($image);
			}
		}

		return $this->images;
	}

	public function getTexts() {
		if (empty($this->texts)) {
			$ids = LookupTextProjectPathDao::getTextIds($this->dao->getProjectId(), $this->getId());
			foreach ($ids as $id) {
				$text = new TextDao($id);
				$this->texts[$id] = new Text($text);
			}
		}

		return $this->texts;
	}

	public function getSubProjectPaths() {
		if (empty($this->subProjectPaths)) {
			$daos = ProjectPathDao::getChildrenPath($this->dao->getProjectId(), $this->getId());
			foreach ($daos as $dao) {
				$this->subProjectPaths[$dao->getId()] = new ProjectPath($dao);
			}
		}

		return $this->subProjectPaths;
	}
}
?>