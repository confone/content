<?php
class TextVersionDao extends TextVersionDaoParent {

	const PREVIEW_VERSION = 0;

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
			if (isset($previewTextVersion)) {
				$textVersion = new TextVersionDao();
				$sequence = $textId;
				$textVersion->setShardId($sequence);

				$textVersion->var = $previewTextVersion->var;

				$builder = new QueryBuilder($textVersion);
				$res = $builder->select('COUNT(*) AS count')
							   ->where('text_id', $textId)
							   ->where('language', $language)
							   ->find();

				$textVersion->setVersion($res['count']);
				return $textVersion->save();
			} else {
				return true;
			}
		} else {
			return false;
		}
	}

	public static function getPreviewText($textId, $language='en') {
		$textVersion = new TextVersionDao();
		$sequence = $textId;
		$textVersion->setServerAddress($sequence);

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
		$textVersion->setServerAddress($sequence);

		$builder = new QueryBuilder($textVersion);
		$res = $builder->select('*')
					   ->where('text_id', $textId)
					   ->where('language', $language)
					   ->order('version', true)
					   ->limit(0, 1)
					   ->find();

		return ContentDaoBase::makeObjectFromSelectResult($res, "TextVersionDao");
	}

	public static function getTexts($textId, $language=null) {
		$textVersion = new TextVersionDao();
		$sequence = $textId;
		$textVersion->setServerAddress($sequence);

		$builder = new QueryBuilder($textVersion);
		$builder->select('*')->where('text_id', $textId);
		if (isset($language)) {
			$builder->where('language', $language);
		}
		$rows = $builder->order('language', true)->findList();

		return ContentDaoBase::makeObjectsFromSelectListResult($rows, "TextVersionDao");
	}

	public static function getTextsInRange($textId, $range, $language=null) {
		$textVersion = new TextVersionDao();
		$sequence = $textId;
		$textVersion->setServerAddress($sequence);

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

	public static function countLanguages($textId) {
		$textVersion = new TextVersionDao();
		$sequence = $textId;
		$textVersion->setServerAddress($sequence);

		$builder = new QueryBuilder($textVersion);
		$res = $builder->select('COUNT(DISTINCT language) as count')
					   ->where('text_id', $textId)
					   ->find();

		return $res['count'];
	}

// ============================================ override functions ==================================================

	protected function doDelete() {
		$sequence = $this->getTextId();
		$this->setServerAddress($sequence);

		$builder = new QueryBuilder($this);
		$builder->delete()->where('id', $this->getId())->query();
	}

	protected function beforeInsert() {
		$sequence = $this->getTextId();
		$this->setShardId($sequence);
		$this->setCreateTime(gmdate('Y-m-d H:i:s'));

		$version = $this->getVersion();
		if (empty($version)) {
			$previewDao = self::getPreviewText($this->getTextId(), $this->getLanguage());
			if (isset($previewDao)) { $previewDao->delete(); }
			$this->setVersion(self::PREVIEW_VERSION);
		}
	}

	protected function beforeUpdate() {
		$sequence = $this->getTextId();
		$this->setServerAddress($sequence);

		$this->setCreateTime(gmdate('Y-m-d H:i:s'));
	}

	protected function isShardBaseObject() {
		return false;
	}
}
?>