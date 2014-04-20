<?php
abstract class TextVersionDaoParent extends ContentDaoBase {

    protected function init() {
        $this->var['id'] = '';
        $this->var['text_id'] = '';
        $this->var['content'] = '';
        $this->var['language'] = '';
        $this->var['version'] = '';
        $this->var['create_time'] = '';

        $this->update['id'] = false;
        $this->update['text_id'] = false;
        $this->update['content'] = false;
        $this->update['language'] = false;
        $this->update['version'] = false;
        $this->update['create_time'] = false;
    }

    public function getId() {
        return $this->var['id'];
    }

    public function setTextId($textId) {
        $this->var['text_id'] = $textId;
        $this->update['text_id'] = true;
    }
    public function getTextId() {
        return $this->var['text_id'];
    }

    public function setContent($content) {
        $this->var['content'] = $content;
        $this->update['content'] = true;
    }
    public function getContent() {
        return $this->var['content'];
    }

    public function setLanguage($language) {
        $this->var['language'] = $language;
        $this->update['language'] = true;
    }
    public function getLanguage() {
        return $this->var['language'];
    }

    public function setVersion($version) {
        $this->var['version'] = $version;
        $this->update['version'] = true;
    }
    public function getVersion() {
        return $this->var['version'];
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
        return 'text_version';
    }

    protected function getIdColumnName() {
        return 'id';
    }

    public function getShardDomain() {
        return 'content_text';
    }
}
?>