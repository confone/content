<?php
class TextVersionDao extends TextVersionDaoParent {

	const PREVIEW_VERSION = -1;

// =============================================== public function =================================================

	public static function updatePreview($textId, $content) {
		$previewTextVersion = TextVersionDao::getPreviewText($textId);
		$previewTextVersion->setContent($content);
		$previewTextVersion->save();
	}

	public static function publish($textId) {
		$text = new TextDao($textId);

		if ($text->isFromDatabase()) {
			$previewTextVersion = TextVersionDao::getPreviewText($textId);
			$textVersion = new TextVersionDao();
			$textVersion->var = $previewTextVersion->var;

			$builder = new QueryBuilder($imageVersion);
			$res = $builder->select('COUNT(*) AS count')->where('text_id', $this->getTextId())->find();

			$textVersion->var[TextVersionDao::VERSION] = $res['count'];
			return $textVersion->save();
		} else {
			return false;
		}
	}

	public static function getPreviewText($textId) {
		$textVersion = new TextVersionDao();
		$sequence = $textId;
		$textVersion->setShardId($sequence);

		$builder = new QueryBuilder($textVersion);
		$res = $builder->select('*')->where('version', self::PREVIEW_VERSION)->find();

		return ContentDaoBase::makeObjectFromSelectResult($res, "TextVersionDao");
	}

	public static function getCurrentText($textId) {
		$textVersion = new TextVersionDao();
		$sequence = $textId;
		$textVersion->setShardId($sequence);

		$builder = new QueryBuilder($textVersion);
		$res = $builder->select('*')->order('id', true)->limit(0, 1)->find();

		return ContentDaoBase::makeObjectFromSelectResult($res, "TextVersionDao");
	}

	public static function getTexts($textId) {
		$textVersion = new TextVersionDao();
		$sequence = $textId;
		$textVersion->setShardId($sequence);

		$builder = new QueryBuilder($textVersion);
		$rows = $builder->select('*')->where('text_id', $textId)->findList();

		return ContentDaoBase::makeObjectsFromSelectListResult($rows, "TextVersionDao");
	}

	public static function isPreviewTextPublished($textId) {
		$currentText = TextVersionDao::getCurrentText($textId);
		$previewText = TextVersionDao::getPreviewText($textId);

		$currentTextContent = $currentText->getContent();
		$previewTextContent = $previewText->getContent();

		return $currentTextContent == $previewTextContent;
	}

// ============================================ override functions ==================================================

	protected function doDelete() {
		$builder = new QueryBuilder($this);
		$builder->delete()->where('id', $this->getId())->query();
	}

	protected function beforeInsert() {
		$previewDao = self::getPreviewText($this->getTextId());
		if (isset($previewDao)) { $previewDao->delete(); }

		$sequence = $this->getTextId();
		$this->setShardId($sequence);
		$this->setCreateTime(gmdate('Y-m-d H:i:s'));
		$this->setVersion(self::PREVIEW_VERSION);
	}

	protected function beforeUpdate() {
		$this->setCreateTime(gmdate('Y-m-d H:i:s'));
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>