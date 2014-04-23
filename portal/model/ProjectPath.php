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
		$input = $this->getInput();
		if (is_array($input)) {
			$this->dao = ProjectPathDao::getProjectPath($input[0], $input[1]);
		} else {
			$this->dao = $this->getInput();
		}
	}
	public function persist() {
		$this->dao->save();
	}

	public function remove() {
		$this->dao->delete();
	}

	public function addImage($imageId) {
		$imageDao = new ImageDao($imageId);

		$lookup = new LookupImageProjectPathDao();
		$lookup->setProjectId($this->dao->getProjectId());
		$lookup->setProjectPathId($this->getId());
		$lookup->setImageId($imageId);
		$lookup->setCode($imageDao->getCode());
		$lookup->save();

		if (!empty($this->images)) {
			$this->images[$imageId] = new Image($imageDao);
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

	public function addText($textId) {
		$textDao = new TextDao($textId);

		$lookup = new LookupTextProjectPathDao();
		$lookup->setProjectId($this->dao->getProjectId());
		$lookup->setProjectPathId($this->getId());
		$lookup->setTextId($textId);
		$lookup->setCode($textDao->getCode());
		$lookup->save();

		if (!empty($this->texts)) {
			$this->texts[$textId] = new Text($textDao);
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
		$pathExist = ProjectPathDao::isProjectPahtExist ( 
					$this->dao->getProjectId(), $this->getId(), $path);

		$rv = false;
		if (!$pathExist) {
			$pathDao = new ProjectPathDao();
			$pathDao->setPath($path);
			$pathDao->setProjectId($this->dao->getProjectId());
			$pathDao->setParentPathId($this->getId());
			$rv = $pathDao->save();

			if (!empty($this->subProjectPaths)) {
				$this->subProjectPaths[$pathDao->getId()] = new ProjectPath($pathDao->getid());
			}
		}

		return $rv;
	}

	public function getSubProjectPaths() {
		if (empty($this->subProjectPaths)) {
			$paths = ProjectPathDao::getChildrenPath($this->dao->getProjectId(), $this->getId());
			foreach ($paths as $path) {
				$this->subProjectPaths[$path->getId()] = new ProjectPath($path);
			}
		}

		return $this->subProjectPaths;
	}

    public function getProjectId() {
        return $this->dao->getProjectId();
    }
    public function getPath() {
        return $this->dao->getPath();
    }
    public function getPathFull() {
        return $this->dao->getPathFull();
    }
    public function isDeleted() {
        return $this->dao->getIsDeleted()!='Y';
    }
    public function getLastModify() {
        return $this->dao->getLastModify();
    }
    public function getCreateTime() {
        return $this->dao->getCreateTime();
    }
}
?>