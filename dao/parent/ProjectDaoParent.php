<?php
abstract class ProjectDaoParent extends ContentDaoBase {

    protected function init() {
        $this->var['id'] = '';
        $this->var['name'] = '';
        $this->var['owner_id'] = '';
        $this->var['private_key'] = '';
        $this->var['public_key'] = '';
        $this->var['last_modify'] = '';
        $this->var['create_time'] = '';

        $this->update['id'] = false;
        $this->update['name'] = false;
        $this->update['owner_id'] = false;
        $this->update['private_key'] = false;
        $this->update['public_key'] = false;
        $this->update['last_modify'] = false;
        $this->update['create_time'] = false;
    }

    public function getId() {
        return $this->var['id'];
    }

    public function setName($name) {
        $this->var['name'] = $name;
        $this->update['name'] = true;
    }
    public function getName() {
        return $this->var['name'];
    }

    public function setOwnerId($ownerId) {
        $this->var['owner_id'] = $ownerId;
        $this->update['owner_id'] = true;
    }
    public function getOwnerId() {
        return $this->var['owner_id'];
    }

    public function setPrivateKey($privateKey) {
        $this->var['private_key'] = $privateKey;
        $this->update['private_key'] = true;
    }
    public function getPrivateKey() {
        return $this->var['private_key'];
    }

    public function setPublicKey($publicKey) {
        $this->var['public_key'] = $publicKey;
        $this->update['public_key'] = true;
    }
    public function getPublicKey() {
        return $this->var['public_key'];
    }

    public function setLastModify($lastModify) {
        $this->var['last_modify'] = $lastModify;
        $this->update['last_modify'] = true;
    }
    public function getLastModify() {
        return $this->var['last_modify'];
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
        return 'project';
    }

    protected function getIdColumnName() {
        return 'id';
    }

    public function getShardDomain() {
        return 'content_project';
    }
}
?>