<?php
class TextVersionDao extends TextVersionDaoParent {

	const PREVIEW_VERSION = -1;

// =============================================== public function =================================================

	public static function updatePreview($textId, $content, $language='en') {
		$previewTextVersion = TextVersionDao::getPreviewText($textId, $language);
		$previewTextVersion->setContent($content);
		$previewTextVersion->setLanguage($language);
		$previewTextVersion->save();
	}

	public static function publish($textId, $language='en') {
		$text = new TextDao($textId);

		if ($text->isFromDatabase()) {
			$previewTextVersion = TextVersionDao::getPreviewText($textId, $language);
			$textVersion = new TextVersionDao();
			$textVersion->var = $previewTextVersion->var;

			$builder = new QueryBuilder($imageVersion);
			$res = $builder->select('COUNT(*) AS count')
						   ->where('text_id', $this->getTextId())
						   ->where('language', $language)
						   ->find();

			$textVersion->setVersion($res['count']);
			return $textVersion->save();
		} else {
			return false;
		}
	}

	public static function getPreviewText($textId, $language='en') {
		$textVersion = new TextVersionDao();
		$sequence = $textId;
		$textVersion->setShardId($sequence);

		$builder = new QueryBuilder($textVersion);
		$res = $builder->select('*')
					   ->where('text_id', $textId)
					   ->where('version', self::PREVIEW_VERSION)
					   ->where('language', $language)
					   ->find();

		return ContentDaoBase::makeObjectFromSelectResult($res, "TextVersionDao");
	}

	public static function getCurrentText($textId, $language='en') {
		$textVersion = new TextVersionDao();
		$sequence = $textId;
		$textVersion->setShardId($sequence);

		$builder = new QueryBuilder($textVersion);
		$res = $builder->select('*')
					   ->where('text_id', $textId)
					   ->where('language', $language)
					   ->order('id', true)
					   ->limit(0, 1)
					   ->find();

		return ContentDaoBase::makeObjectFromSelectResult($res, "TextVersionDao");
	}

	public static function getTexts($textId, $language=null) {
		$textVersion = new TextVersionDao();
		$sequence = $textId;
		$textVersion->setShardId($sequence);

		$builder = new QueryBuilder($textVersion);
		$builder->select('*')->where('text_id', $textId);
		if (isset($language)) {
			$builder->where('language', $language);
		}
		$rows = $builder->findList();

		return ContentDaoBase::makeObjectsFromSelectListResult($rows, "TextVersionDao");
	}

	public static function getTextsInRange($textId, $range, $language=null) {
		$textVersion = new TextVersionDao();
		$sequence = $textId;
		$textVersion->setShardId($sequence);

		$builder = new QueryBuilder($textVersion);
		$builder->select('*')->in('id', $range);
		if (isset($language)) {
			$builder->where('language', $language);
		}
		$rows = $builder->findList();

		return ContentDaoBase::makeObjectsFromSelectListResult($rows, "TextVersionDao");
	}

	public static function isPreviewTextPublished($textId, $language='en') {
		$currentText = TextVersionDao::getCurrentText($textId, $language);
		$previewText = TextVersionDao::getPreviewText($textId, $language);

		$currentTextContent = $currentText->getContent();
		$previewTextContent = $previewText->getContent();

		return $currentTextContent == $previewTextContent;
	}

// ============================================ override functions ==================================================

	protected function doDelete() {
Logger::info('i am here ... 0');
		$builder = new QueryBuilder($this);
		$builder->delete()->where('id', $this->getId())->query();
Logger::info('i am here ... 1');
	}

	protected function beforeInsert() {
		$sequence = $this->getTextId();
		$this->setShardId($sequence);
		$this->setCreateTime(gmdate('Y-m-d H:i:s'));
		$this->setVersion(self::PREVIEW_VERSION);

		$previewDao = self::getPreviewText($this->getTextId(), $this->getLanguage());
		if (isset($previewDao)) { $previewDao->delete(); }
	}

	protected function beforeUpdate() {
		$this->setCreateTime(gmdate('Y-m-d H:i:s'));
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>