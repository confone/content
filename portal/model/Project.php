<?php
class Project extends Model {

	private $dao = null;

	private $rootPath = null;

	public function getId() {
		return $this->dao->getId();
	}
	protected function init() {
		$input = $this->getInput();
		if (is_numeric($input)) {
			$this->dao = new ProjectDao($input);
		} else {
			$this->dao = $this->getInput();
		}
	}
	public function persist() {
		$this->dao->save();
	}

    public function getRootPath() {
    	if (!isset($this->rootPath)) {
    		$pathDao = ProjectPathDao::getProjectRootPath($this->getId());
    		$this->rootPath = new ProjectPath($pathDao);
    	}

    	return $this->rootPath;
    }

    public function addImage($code) {
    	if (empty($code)) { return -1; }

		$image = new ImageDao();
		$image->setAccountId($this->dao->getOwnerId());
		$image->setCode($code);
		$image->setProjectId($this->getId());
		$image->save();

		$this->getRootPath()->addImage($image->getId());

		return $image->getId();
    }

    public function addText($code) {
    	if (empty($code)) { return -1; }

		$text = new TextDao();
		$text->setAccountId($this->dao->getOwnerId());
		$text->setCode($code);
		$text->setProjectId($this->getId());
		$text->save();

		$this->getRootPath()->addText($text->getId());

		return $text->getId();
    }

    public function isAvailableToUser($userId) {
    	$access = LookupProjectAccountDao::getUserAccessLevelOnProject($this->getId(), $userId);
    	return $access != ProjectDao::ACCESSLEVEL_NONE;
    }

    public function setName($name) {
    	$this->dao->setName($name);
    }
    public function getName() {
        return $this->dao->getName();
    }
    public function getDescription() {
    	return $this->dao->getDescription();
    }
    public function getOwnerId() {
        return $this->dao->getOwnerId();
    }
    public function getPrivateKey() {
        return $this->dao->getPrivateKey();
    }
    public function getPublicKey() {
        return $this->dao->getPublicKey();
    }
    public function getLastModify() {
        return $this->dao->getLastModify();
    }
    public function getCreateTime() {
        return $this->dao->getCreateTime();
    }
}
?>