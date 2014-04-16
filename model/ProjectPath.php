<?php
class ProjectPath extends Model {

	private $dao = null;

	private $images = array();

	private $texts = array();

	private $subProjectPaths = array();

	public function getId() {
		return $this->dao->getId();
	}
	protected function init() {
		$this->dao = $this->getInput();
	}
	public function persist() {
		$this->dao->save();
	}

	public function remove() {
		$this->dao->delete();
	}

	public function addImage($userId, $code) {
		$image = new ImageDao();
		$image->setAccountId($userId);
		$image->setCode($code);
		$image->setProjectId($this->dao->getProjectId());
		$image->setProjectPathId($this->getId());
		$image->save();

		if (!empty($this->images)) {
			$this->images[$image->getId()] = new Image($image);
		}
	}

	public function getImages() {
		if (empty($this->images)) {
			$images = ImageDao::getImages($this->dao->getProjectId(), $this->getId());
			foreach ($images as $image) {
				$this->images[$image->getId()] = new Image($image);
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
			$texts = TextDao::getTexts($this->dao->getProjectId(), $this->getId());
			foreach ($texts as $text) {
				$this->texts[$text->getId()] = new Text($text);
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
			$ids = ProjectPathDao::getSubPathIds($this->dao->getProjectId(), $this->getId());
			foreach ($ids as $id) {
				$this->subProjectPaths[$id] = new ProjectPath($id);
			}
		}

		return $this->subProjectPaths;
	}
}
?>