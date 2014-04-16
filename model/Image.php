<?php
class Image extends Model {

	private $dao = null;

	private $owner = null;

	private $versions = array();

	public function getId() {
		return $this->dao->getId();
	}
	protected function init() {
		$input = $this->getInput();
		if (is_numeric($input)) {
			$this->dao = new ImageDao($input);
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

	public function addNewVersion($filePath) {
		$versionDao = new ImageVersionDao();
		$versionDao->setFilePath($filePath);
		$versionDao->setImageId($this->getId());
		$versionDao->save();

		if (!empty($this->versions)) {
			$this->versions[ImageVersionDao::PREVIEW_VERSION] = $versionDao;
		}
	}

	public function getAllVersionFiles() {
		if (empty($this->versions)) {
			$imageVersionDaos = ImageVersionDao::getImages($this->getId());
			foreach ($imageVersionDaos as $imageVersionDao) {
				$version = $imageVersionDao->getVersion();
				$this->versions[$version] = array();
				$this->versions[$version]['file_path'] = $imageVersionDao->getFilePath();
				$this->versions[$version]['create_time'] = $imageVersionDao->getCreateTime();
			}
		}

		return $this->versions;
	}

	public function publishNewVersion() {
		return ImageVersionDao::publish($this->getId());
	}

	public function getFilePath() {
		$path = '';

		$versionDao = ImageVersionDao::getCurrentImage($this->getId());
		if (isset($versionDao)) {
			$path = $versionDao->getFilePath();
		}

		return $path;
	}

	public function getPreviewFilePath() {
		$path = '';

		$versionDao = ImageVersionDao::getPreviewImage($this->getId());
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