<?php
abstract class ItermRelationDaoParent extends ContentDaoBase {

    protected function init() {
        $this->var['id'] = '';
        $this->var['parent_code'] = '';
        $this->var['child_id'] = '';
        $this->var['type'] = '';

        $this->update['id'] = false;
        $this->update['parent_code'] = false;
        $this->update['child_id'] = false;
        $this->update['type'] = false;
    }

    public function getId() {
        return $this->var['id'];
    }

    public function setParentCode($parentCode) {
        $this->var['parent_code'] = $parentCode;
        $this->update['parent_code'] = true;
    }
    public function getParentCode() {
        return $this->var['parent_code'];
    }

    public function setChildId($childId) {
        $this->var['child_id'] = $childId;
        $this->update['child_id'] = true;
    }
    public function getChildId() {
        return $this->var['child_id'];
    }

    public function setType($type) {
        $this->var['type'] = $type;
        $this->update['type'] = true;
    }
    public function getType() {
        return $this->var['type'];
    }

// ======================================================================================== override

    public function getTableName() {
        return 'iterm_relation';
    }

    protected function getIdColumnName() {
        return 'id';
    }

    public function getShardDomain() {
        return 'content_iterm';
    }
}
?>