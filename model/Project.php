<?php
class Project extends Model {

	private $dao = null;

	private $rootPath = array();

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
    	if (empty($this->rootPath)) {
    		$pathDao = ProjectPathDao::getProjectRootPath($this->getId());
    		$this->rootPath = new ProjectPath($pathDao);
    	}

    	return $this->rootPath;
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
    public function getOwnerId() {
        return $this->dao->getOwnerId();
    }
    public function getLastModify() {
        return $this->dao->getLastModify();
    }
    public function getCreateTime() {
        return $this->dao->getCreateTime();
    }
}
?>