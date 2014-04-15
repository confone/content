<?php
abstract class ClientDaoParent extends ContentDaoBase {

    protected function init() {
        $this->var['id'] = '';
        $this->var['project_key'] = '';
        $this->var['name'] = '';
        $this->var['scope'] = '';
        $this->var['create_time'] = '';
        $this->var['modified_time'] = '';

        $this->update['id'] = false;
        $this->update['project_key'] = false;
        $this->update['name'] = false;
        $this->update['scope'] = false;
        $this->update['create_time'] = false;
        $this->update['modified_time'] = false;
    }

    public function getId() {
        return $this->var['id'];
    }

    public function setProjectKey($projectKey) {
        $this->var['project_key'] = $projectKey;
        $this->update['project_key'] = true;
    }
    public function getProjectKey() {
        return $this->var['project_key'];
    }

    public function setName($name) {
        $this->var['name'] = $name;
        $this->update['name'] = true;
    }
    public function getName() {
        return $this->var['name'];
    }

    public function setScope($scope) {
        $this->var['scope'] = $scope;
        $this->update['scope'] = true;
    }
    public function getScope() {
        return $this->var['scope'];
    }

    public function setCreateTime($createTime) {
        $this->var['create_time'] = $createTime;
        $this->update['create_time'] = true;
    }
    public function getCreateTime() {
        return $this->var['create_time'];
    }

    public function setModifiedTime($modifiedTime) {
        $this->var['modified_time'] = $modifiedTime;
        $this->update['modified_time'] = true;
    }
    public function getModifiedTime() {
        return $this->var['modified_time'];
    }

// ======================================================================================== override

    public function getTableName() {
        return 'client';
    }

    protected function getIdColumnName() {
        return 'id';
    }

    public function getShardDomain() {
        return 'content_client';
    }
}
?>