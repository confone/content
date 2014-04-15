<?php
abstract class ItermDaoParent extends ContentDaoBase {

    protected function init() {
        $this->var['id'] = '';
        $this->var['code'] = '';
        $this->var['type'] = '';
        $this->var['language'] = '';
        $this->var['description'] = '';
        $this->var['active'] = '';

        $this->update['id'] = false;
        $this->update['code'] = false;
        $this->update['type'] = false;
        $this->update['language'] = false;
        $this->update['description'] = false;
        $this->update['active'] = false;
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

    public function setType($type) {
        $this->var['type'] = $type;
        $this->update['type'] = true;
    }
    public function getType() {
        return $this->var['type'];
    }

    public function setLanguage($language) {
        $this->var['language'] = $language;
        $this->update['language'] = true;
    }
    public function getLanguage() {
        return $this->var['language'];
    }

    public function setDescription($description) {
        $this->var['description'] = $description;
        $this->update['description'] = true;
    }
    public function getDescription() {
        return $this->var['description'];
    }

    public function setActive($active) {
        $this->var['active'] = $active;
        $this->update['active'] = true;
    }
    public function getActive() {
        return $this->var['active'];
    }

// ======================================================================================== override

    public function getTableName() {
        return 'iterm';
    }

    protected function getIdColumnName() {
        return 'id';
    }

    public function getShardDomain() {
        return 'content_iterm';
    }
}
?>