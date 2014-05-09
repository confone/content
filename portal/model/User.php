<?php
class User extends Model {

	private $projects = array();
	private $image = null;
	private $name = null;

	public function getId() {
		return $this->getInput();
	}

	protected function init() {}
    public function persist() {}

	public function addProject($name, $description=null) {
		$rv = false;

		$project = new ProjectDao();
		$project->setName($name);
		if (empty($description)) {
			$description = '(no description)';
		}
		$project->setDescription($description);
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
				$this->projects[$lookup->getProjectId()] = new Project($project);
			}
		}

		return $this->projects;
	}

	public function setProfileImage($image) {
		$this->image = $image;
	}
	public function getProfileImage() {
		return $this->image;
	}
	public function setName($name) {
		$this->name = $name;
	}
	public function getName() {
		return $this->name;
	}
}
?>