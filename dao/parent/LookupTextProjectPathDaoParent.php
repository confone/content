<?php
abstract class LookupTextProjectPathDaoParent extends ContentDaoBase {

    protected function init() {
        $this->var['id'] = '';
        $this->var['project_path_id'] = '';
        $this->var['text_id'] = '';

        $this->update['id'] = false;
        $this->update['project_path_id'] = false;
        $this->update['text_id'] = false;
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

    public function setTextId($textId) {
        $this->var['text_id'] = $textId;
        $this->update['text_id'] = true;
    }
    public function getTextId() {
        return $this->var['text_id'];
    }

// ======================================================================================== override

    public function getTableName() {
        return 'lookup_text_project_path';
    }

    protected function getIdColumnName() {
        return 'id';
    }

    public function getShardDomain() {
        return 'content_lookup_text';
    }
}
?>