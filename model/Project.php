<?php
class Project extends Model {

	private $projectPaths = array();

    public function addProjectPath($projectPath) {
    	$projectPath->setProjectId($this->getId());
    	$projectPath->persist();

    	$this->projectPaths[$projectPath->getId()] = $projectPath;
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
    public function setOwnerId($ownerId) {
    	$this->dao->setOwnerId($ownerId);
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