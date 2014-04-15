<?php
abstract class LookupProjectAccountDaoParent extends ContentDaoBase {

    protected function init() {
        $this->var['id'] = '';
        $this->var['project_id'] = '';
        $this->var['account_id'] = '';
        $this->var['access_level'] = '';

        $this->update['id'] = false;
        $this->update['project_id'] = false;
        $this->update['account_id'] = false;
        $this->update['access_level'] = false;
    }

    public function getId() {
        return $this->var['id'];
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

    public function setAccessLevel($accessLevel) {
        $this->var['access_level'] = $accessLevel;
        $this->update['access_level'] = true;
    }
    public function getAccessLevel() {
        return $this->var['access_level'];
    }

// ======================================================================================== override

    public function getTableName() {
        return 'lookup_project_account';
    }

    protected function getIdColumnName() {
        return 'id';
    }

    public function getShardDomain() {
        return 'content_lookup_project';
    }
}
?>