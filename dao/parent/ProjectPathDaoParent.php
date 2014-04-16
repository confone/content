<?php
abstract class ProjectPathDaoParent extends ContentDaoBase {

    protected function init() {
        $this->var['id'] = '';
        $this->var['project_id'] = '';
        $this->var['parent_path_id'] = '';
        $this->var['path'] = '';
        $this->var['path_full'] = '';
        $this->var['is_deleted'] = '';
        $this->var['last_modify'] = '';
        $this->var['create_time'] = '';

        $this->update['id'] = false;
        $this->update['project_id'] = false;
        $this->update['parent_path_id'] = false;
        $this->update['path'] = false;
        $this->update['path_full'] = false;
        $this->update['is_deleted'] = false;
        $this->update['last_modify'] = false;
        $this->update['create_time'] = false;
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

    public function setParentPathId($parentPathId) {
        $this->var['parent_path_id'] = $parentPathId;
        $this->update['parent_path_id'] = true;
    }
    public function getParentPathId() {
        return $this->var['parent_path_id'];
    }

    public function setPath($path) {
        $this->var['path'] = $path;
        $this->update['path'] = true;
    }
    public function getPath() {
        return $this->var['path'];
    }

    public function setPathFull($pathFull) {
        $this->var['path_full'] = $pathFull;
        $this->update['path_full'] = true;
    }
    public function getPathFull() {
        return $this->var['path_full'];
    }

    public function setIsDeleted($isDeleted) {
        $this->var['is_deleted'] = $isDeleted;
        $this->update['is_deleted'] = true;
    }
    public function getIsDeleted() {
        return $this->var['is_deleted'];
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
        return 'project_path';
    }

    protected function getIdColumnName() {
        return 'id';
    }

    public function getShardDomain() {
        return 'content_project';
    }
}
?>