<?php
class TextVersionDao extends ConfoneDao {

	const TEXTID = 'text_id';
	const FILEPATH = 'file_path';
	const VERSION = 'version';
	const CREATETIME = 'create_time';

	const IDCOLUMN = 'id';
	const SHARDDOMAIN = 'confone_text';
	const TABLE = 'text_version';


// =============================================== public function =================================================



// ============================================ override functions ==================================================

	protected function init() {
		$this->var[TextVersionDao::IDCOLUMN] = 0;
		$this->var[TextVersionDao::TEXTID] = 0;
		$this->var[TextVersionDao::FILEPATH] = '';
		$this->var[TextVersionDao::VERSION] = -1;
		$this->var[TextVersionDao::CREATETIME] = gmdate('Y-m-d H:i:s');
	}

	protected function beforeInsert() {
		$sequence = Utility::hashString($this->var[TextVersionDao::TEXTID]);
		$this->setShardId($sequence);

		$sql = "UPDATE ".TextVersionDao::TABLE." SET "
				.TextVersionDao::VERSION."=".TextVersionDao::VERSION."+1 WHERE "
				.TextVersionDao::TEXTID."=".$this->var[TextVersionDao::TEXTID];

		$connect = DBUtil::getConn($this);
		DBUtil::updateData($connect, $sql);
	}

	public function getShardDomain() {
		return TextVersionDao::SHARDDOMAIN;
	}

	public function getTableName() {
		return TextVersionDao::TABLE;
	}

	public function getIdColumnName() {
		return TextVersionDao::IDCOLUMN;
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>