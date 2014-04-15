<?php
abstract class LookupImageCodeDaoParent extends ContentDaoBase {

    protected function init() {
        $this->var['id'] = '';
        $this->var['code'] = '';
        $this->var['image_id'] = '';
        $this->var['project_id'] = '';

        $this->update['id'] = false;
        $this->update['code'] = false;
        $this->update['image_id'] = false;
        $this->update['project_id'] = false;
    }

    public function getId() {
        return $this->var['id'];
    }

    public function setCode($code) {
        $this->var['code'] = $code;
        $this->update['code'] = true;
    }
    public function getCode() {
        return $this->var['code'];
    }

    public function setImageId($imageId) {
        $this->var['image_id'] = $imageId;
        $this->update['image_id'] = true;
    }
    public function getImageId() {
        return $this->var['image_id'];
    }

    public function setProjectId($projectId) {
        $this->var['project_id'] = $projectId;
        $this->update['project_id'] = true;
    }
    public function getProjectId() {
        return $this->var['project_id'];
    }

// ======================================================================================== override

    public function getTableName() {
        return 'lookup_image_code';
    }

    protected function getIdColumnName() {
        return 'id';
    }

    public function getShardDomain() {
        return 'content_lookup_image';
    }
}
?>