<?php
abstract class ImageDaoParent extends ContentDaoBase {

    protected function init() {
        $this->var['id'] = '';
        $this->var['code'] = '';
        $this->var['project_id'] = '';
        $this->var['account_id'] = '';
        $this->var['create_time'] = '';
        $this->var['last_modify'] = '';

        $this->update['id'] = false;
        $this->update['code'] = false;
        $this->update['project_id'] = false;
        $this->update['account_id'] = false;
        $this->update['create_time'] = false;
        $this->update['last_modify'] = false;
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

    public function setProjectId($projectId) {
        $this->var['project_id'] = $projectId;
        $this->update['project_id'] = true;
    }
    public function getProjectId() {
        return $this->var['project_id'];
    }

    public function setAccountId($accountId) {
        $this->var['account_id'] = $accountId;
        $this->update['account_id'] = true;
    }
    public function getAccountId() {
        return $this->var['account_id'];
    }

    public function setCreateTime($createTime) {
        $this->var['create_time'] = $createTime;
        $this->update['create_time'] = true;
    }
    public function getCreateTime() {
        return $this->var['create_time'];
    }

    public function setLastModify($lastModify) {
        $this->var['last_modify'] = $lastModify;
        $this->update['last_modify'] = true;
    }
    public function getLastModify() {
        return $this->var['last_modify'];
    }

// ======================================================================================== override

    public function getTableName() {
        return 'image';
    }

    protected function getIdColumnName() {
        return 'id';
    }

    public function getShardDomain() {
        return 'content_image';
    }
}
?>