<?php
class TextVersionDao extends ContentDao {

	const TEXTID = 'text_id';
	const CONTENT = 'content';
	const VERSION = 'version';
	const CREATETIME = 'create_time';

	const IDCOLUMN = 'id';
	const SHARDDOMAIN = 'confone_text';
	const TABLE = 'text_version';


// =============================================== public function =================================================

	public static function updatePreview($textId, $content) {
		$previewTextVersion = TextVersionDao::getPreviewText($textId);
		$previewTextVersion->var[TextVersionDao::CONTENT] = $content;
		$previewTextVersion->save();
	}

	public static function publish($textId) {
		$text = new TextDao($textId);

		if ($text->isFromDatabase()) {
			$previewTextVersion = TextVersionDao::getPreviewText($textId);
			$textVersion = new TextVersionDao();
			$textVersion->var = $previewTextVersion->var;

			$sql = "SELECT COUNT(*) AS count FROM ".TextVersionDao::TABLE." WHERE "
					.TextVersionDao::TEXTID."=".$this->var[TextVersionDao::TEXTID];
			$connect = DBUtil::getConn($textVersion);
			$res = DBUtil::selectData($connect, $sql);

			$textVersion->var[TextVersionDao::VERSION] = $res['count'];
			return $textVersion->save();
		} else {
			return false;
		}
	}

	public static function getPreviewText($textId) {
		$textVersion = new TextVersionDao();
		$sequence = Utility::hashString($textId);
		$textVersion->setShardId($sequence);

		$sql = "SELECT * from ".TextVersionDao::TABLE." WHERE "
				.TextVersionDao::VERSION."=-1";

		$connect = DBUtil::getConn($textVersion);
		$res = DBUtil::selectData($connect, $sql);

		return ContentDao::makeObjectFromSelectResult($res, "TextVersionDao");
	}

	public static function getCurrentText($textId) {
		$textVersion = new TextVersionDao();
		$sequence = Utility::hashString($textId);
		$textVersion->setShardId($sequence);

		$sql = "SELECT * from ".TextVersionDao::TABLE." ORDER BY "
				.TextVersionDao::IDCOLUMN." DESC LIMIT 0, 1";

		$connect = DBUtil::getConn($textVersion);
		$res = DBUtil::selectData($connect, $sql);

		return ContentDao::makeObjectFromSelectResult($res, "TextVersionDao");
	}

	public static function getTexts($textId) {
		$textVersion = new TextVersionDao();
		$sequence = Utility::hashString($textId);
		$textVersion->setShardId($sequence);

		$sql = "SELECT * from ".TextVersionDao::TABLE." WHERE "
				.TextVersionDao::TEXTID."=$textId";

		$connect = DBUtil::getConn($textVersion);
		$rows = DBUtil::selectDataList($connect, $sql);

		return ContentDao::makeObjectsFromSelectListResult($rows, "TextVersionDao");
	}

	public static function isPreviewTextPublished($textId) {
		$currentText = TextVersionDao::getCurrentText($textId);
		$previewText = TextVersionDao::getPreviewText($textId);

		$currentTextContent = $currentText->var[TextVersionDao::CONTENT];
		$previewTextContent = $previewText->var[TextVersionDao::CONTENT];

		return $currentTextContent == $previewTextContent;
	}

// ============================================ override functions ==================================================

	protected function init() {
		$this->var[TextVersionDao::IDCOLUMN] = 0;
		$this->var[TextVersionDao::TEXTID] = 0;
		$this->var[TextVersionDao::CONTENT] = '';
		$this->var[TextVersionDao::VERSION] = -1;
		$this->var[TextVersionDao::CREATETIME] = '';
	}

	protected function beforeInsert() {
		$sequence = Utility::hashString($this->var[TextVersionDao::TEXTID]);
		$this->setShardId($sequence);
		$this->var[TextVersionDao::CREATETIME] = gmdate('Y-m-d H:i:s');
	}

	protected function beforeUpdate() {
		$sequence = Utility::hashString($this->var[TextVersionDao::TEXTID]);
		$this->setShardId($sequence);
		$this->var[TextVersionDao::CREATETIME] = gmdate('Y-m-d H:i:s');
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