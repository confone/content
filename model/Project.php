<?php
class Project extends Model {

	private $dao = null;

	private $projectPaths = array();

	public function getId() {
		return $this->dao->getId();
	}
	protected function init() {
		$this->dao = $this->getInput();
	}
	public function persist() {
		$this->dao->save();
	}

    public function addProjectPath($path) {
		$pathDao = new ProjectPathDao();
		$pathDao->setPath($path);
		$pathDao->setProjectId($this->dao->getProjectId());
		$pathDao->setParentPathId(0);
		$pathDao->save();

		if (!empty($this->projectPaths)) {
			$this->projectPaths[$pathDao->getId()] = new ProjectPath($pathDao->getid());
		}
    }

    public function removeProjectPath($projectPath) {
    	$projectPath->remove();
    	unset($this->projectPaths[$projectPath->getId()]);
    }

    public function getRootLevelPaths() {
    	if (empty($this->projectPaths)) {
	    	$paths = ProjectPathDao::getChildrenPath($this->getId());
	    	foreach ($paths as $path) {
	    		$this->projectPaths[$path->getId()] = new ProjectPath($path);
	    	}
    	}

    	return $this->projectPaths;
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