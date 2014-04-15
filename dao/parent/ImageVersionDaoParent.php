<?php
abstract class ImageVersionDaoParent extends ContentDaoBase {

    protected function init() {
        $this->var['id'] = '';
        $this->var['image_id'] = '';
        $this->var['file_path'] = '';
        $this->var['version'] = '';
        $this->var['create_time'] = '';

        $this->update['id'] = false;
        $this->update['image_id'] = false;
        $this->update['file_path'] = false;
        $this->update['version'] = false;
        $this->update['create_time'] = false;
    }

    public function getId() {
        return $this->var['id'];
    }

    public function setImageId($imageId) {
        $this->var['image_id'] = $imageId;
        $this->update['image_id'] = true;
    }
    public function getImageId() {
        return $this->var['image_id'];
    }

    public function setFilePath($filePath) {
        $this->var['file_path'] = $filePath;
        $this->update['file_path'] = true;
    }
    public function getFilePath() {
        return $this->var['file_path'];
    }

    public function setVersion($version) {
        $this->var['version'] = $version;
        $this->update['version'] = true;
    }
    public function getVersion() {
        return $this->var['version'];
    }

    public function setCreateTime($createTime) {
        $this->var['create_time'] = $createTime;
        $this->update['create_time'] = true;
    }
    public function getCreateTime() {
        return $this->var['create_time'];
    }

// ======================================================================================== override

    public function getTableName() {
        return 'image_version';
    }

    protected function getIdColumnName() {
        return 'id';
    }

    public function getShardDomain() {
        return 'content_image';
    }
}
?>