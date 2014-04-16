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