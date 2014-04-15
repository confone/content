<?php
abstract class LookupPubkeyProjectDaoParent extends ContentDaoBase {

    protected function init() {
        $this->var['id'] = '';
        $this->var['pub_key'] = '';
        $this->var['project_id'] = '';

        $this->update['id'] = false;
        $this->update['pub_key'] = false;
        $this->update['project_id'] = false;
    }

    public function getId() {
        return $this->var['id'];
    }

    public function setPubKey($pubKey) {
        $this->var['pub_key'] = $pubKey;
        $this->update['pub_key'] = true;
    }
    public function getPubKey() {
        return $this->var['pub_key'];
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
        return 'lookup_pubkey_project';
    }

    protected function getIdColumnName() {
        return 'id';
    }

    public function getShardDomain() {
        return 'content_lookup_project';
    }
}
?>