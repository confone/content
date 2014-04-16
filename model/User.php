<?php
class User extends Model {

	private $projects = array();

	public function getId() {
		return $this->getInput();
	}

	protected function init() {}
    public function persist() {}

	public function addProject($name) {
		$rv = false;

		$project = new ProjectDao();
		$project->setName($name);
		$project->setOwnerId($this->getId());
		$rv = $project->save();

		$projectPath = new ProjectPathDao();
		$projectPath->setParentPathId(0);
		$projectPath->setProjectId($project->getId());
		$projectPath->setPath(ProjectPathDao::ROOT_PATH);
		$projectPath->save();

		if (empty($this->projects)) {
			$this->projects[$project->getId()] = new Project($project);
		}

		return $rv;
	}

	public function removeProject($project) {
		LookupProjectAccountDao::removeLookup($project->getId(), $this->getId());
		unset($this->projects[$project->getId()]);
	}

	public function getProjects() {
		if (empty($this->projects)) {
			$lookups = LookupProjectAccountDao::getLookupsByAccountId($this->getId());
			foreach ($lookups as $lookup) {
				$project = new ProjectDao($lookup->getProjectId());
				$this->projects[$lookup->getId()] = new Project($project);
			}
		}

		return $this->projects;
	}
}
?>