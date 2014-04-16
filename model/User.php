<?php
class User extends Model {

	private $projects = array();

	protected function init() {}
	public function persist() {}

	public function addProject($project) {
		$lookup = new LookupProjectAccountDao();
		$lookup->setAccountId($this->getId());
		$lookup->setProjectId($project->getId());
		$lookup->save();

		$this->projects[$project->getId()] = $project;
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