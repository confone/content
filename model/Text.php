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

	public function addNewVersion($content) {
		$versionDao = new TextVersionDao();
		$versionDao->setContent($content);
		$versionDao->setTextId($this->getId());
		$versionDao->save();

		if (!empty($this->versions)) {
			$this->versions[TextVersionDao::PREVIEW_VERSION] = $versionDao;
		}
	}

	public function getAllVersionContent() {
		if (empty($this->versions)) {
			$textVersionDaos = TextVersionDao::getTexts($this->getId());
			foreach ($textVersionDaos as $textVersionDao) {
				$version = $textVersionDao->getVersion();
				$this->versions[$version] = array();
				$this->versions[$version]['file_path'] = $textVersionDao->getFilePath();
				$this->versions[$version]['create_time'] = $textVersionDao->getCreateTime();
			}
		}

		return $this->versions;
	}

	public function publishNewVersion() {
		return TextVersionDao::publish($this->getId());
	}

	public function getContent() {
		$path = '';

		$versionDao = TextVersionDao::getCurrentText($this->getId());
		if (isset($versionDao)) {
			$path = $versionDao->getContent();
		}

		return $path;
	}

	public function getPreviewFilePath() {
		$path = '';

		$versionDao = TextVersionDao::getPreviewText($this->getId());
		if (isset($versionDao)) {
			$path = $versionDao->getFilePath();
		}

		return $path;
	}

    public function setCode($code) {
        $this->dao->setCode($code);
    }
    public function getCode() {
        return $this->dao->getCode();
    }

    public function getCreateTime() {
        return $this->dao->getCreateTime();
    }
    public function getLastModify() {
        return $this->dao->getLastModify();
    }
}
?>