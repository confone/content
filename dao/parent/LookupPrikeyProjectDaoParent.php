<?php
abstract class LookupPrikeyProjectDaoParent extends ContentDaoBase {

    protected function init() {
        $this->var['id'] = '';
        $this->var['pri_key'] = '';
        $this->var['project_id'] = '';

        $this->update['id'] = false;
        $this->update['pri_key'] = false;
        $this->update['project_id'] = false;
    }

    public function getId() {
        return $this->var['id'];
    }

    public function setPriKey($priKey) {
        $this->var['pri_key'] = $priKey;
        $this->update['pri_key'] = true;
    }
    public function getPriKey() {
        return $this->var['pri_key'];
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
        return 'lookup_prikey_project';
    }

    protected function getIdColumnName() {
        return 'id';
    }

    public function getShardDomain() {
        return 'content_lookup_project';
    }
}
?>