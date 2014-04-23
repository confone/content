<?php
abstract class LookupImageProjectPathDaoParent extends ContentDaoBase {

    protected function init() {
        $this->var['id'] = '';
        $this->var['project_path_id'] = '';
        $this->var['project_id'] = '';
        $this->var['image_id'] = '';
        $this->var['code'] = '';

        $this->update['id'] = false;
        $this->update['project_path_id'] = false;
        $this->update['project_id'] = false;
        $this->update['image_id'] = false;
        $this->update['code'] = false;
    }

    public function getId() {
        return $this->var['id'];
    }

    public function setProjectPathId($projectPathId) {
        $this->var['project_path_id'] = $projectPathId;
        $this->update['project_path_id'] = true;
    }
    public function getProjectPathId() {
        return $this->var['project_path_id'];
    }

    public function setProjectId($projectId) {
        $this->var['project_id'] = $projectId;
        $this->update['project_id'] = true;
    }
    public function getProjectId() {
        return $this->var['project_id'];
    }

    public function setImageId($imageId) {
        $this->var['image_id'] = $imageId;
        $this->update['image_id'] = true;
    }
    public function getImageId() {
        return $this->var['image_id'];
    }

    public function setCode($code) {
        $this->var['code'] = $code;
        $this->update['code'] = true;
    }
    public function getCode() {
        return $this->var['code'];
    }

// ======================================================================================== override

    public function getTableName() {
        return 'lookup_image_project_path';
    }

    protected function getIdColumnName() {
        return 'id';
    }

    public function getShardDomain() {
        return 'content_lookup_image';
    }
}
?>