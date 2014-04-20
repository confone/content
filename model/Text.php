<?php
class Text extends Model {

	private $dao = null;

	private $owner = null;

	private $versions = array();

	public function getId() {
		return $this->dao->getId();
	}
	protected function init() {
		$input = $this->getInput();
		if (is_numeric($input)) {
			$this->dao = new TextDao($input);
		} else {
			$this->dao = $this->getInput();
		}
	}
	public function persist() {
		$this->dao->save();
	}

	public function setOwnerId($ownerId) {
		$this->dao->setAccountId($ownerId);
	}

	public function getOwner() {
		if (!isset($this->owner)) {
			$this->owner = new User($this->dao->getAccountId());
		}

		return $this->owner;
	}

	public function addNewVersion($content, $language='en') {
		$versionDao = new TextVersionDao();
		$versionDao->setContent($content);
		$versionDao->setTextId($this->getId());
		$versionDao->setLanguage($language);
		$versionDao->save();

		if (!empty($this->versions)) {
			if (!isset($this->versions[$language])) {
				$this->versions[$language] = array();
			}
			$this->versions[$language][TextVersionDao::PREVIEW_VERSION] = $versionDao;
		}
	}

	public function getAllVersionContent() {
		if (empty($this->versions)) {
			$textVersionDaos = TextVersionDao::getTexts($this->getId());
			foreach ($textVersionDaos as $textVersionDao) {
				$language = $textVersionDao->getLanguage();
				if (!isset($this->versions[$language])) {
					$this->versions[$language] = array();
				}
				$version = $textVersionDao->getVersion();
				$this->versions[$language][$version] = array();
				$this->versions[$language][$version]['content'] = $textVersionDao->getContent();
				$this->versions[$language][$version]['create_time'] = $textVersionDao->getCreateTime();
			}
		}

		return $this->versions;
	}

	public function publishNewVersion($language='en') {
		return TextVersionDao::publish($this->getId(), $language);
	}

	public function getContent($language='en') {
		$path = '';

		$versionDao = TextVersionDao::getCurrentText($this->getId(), $language);
		if (isset($versionDao)) {
			$path = $versionDao->getContent();
		}

		return $path;
	}

	public function getPreviewContent($language='en') {
		$path = '';

		$versionDao = TextVersionDao::getPreviewText($this->getId(), $language);
		if (isset($versionDao)) {
			$path = $versionDao->getContent();
		}

		return $path;
	}

    public function setCode($code) {
        $this->dao->setCode($code);
    }
    public function getCode() {
        return $this->dao->getCode();
    }
	public function getProjectId() {
		return $this->dao->getProjectId();
	}
    public function getAccountId() {
        return $this->dao->getAccountId();
    }
    public function getCreateTime() {
        return $this->dao->getCreateTime();
    }
    public function getLastModify() {
        return $this->dao->getLastModify();
    }
}
?>