<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class FeedProviderValueTranslateRepository extends BaseRepository {

	/**
	 * @param FeedProviderValueTranslateDbMapper $dbMapper
	 */
	public function __construct(FeedProviderValueTranslateDbMapper $dbMapper) {
		$this->dbMapper = $dbMapper;
	}

	/**
	 * @param FeedProviderValueTranslateEntity[] $entities
	 */
	public function saveEntities($entities) {
		$this->dbMapper->saveEntities($entities);
	}

	/**
	 * @param FeedProviderLanguageEntity $feedProviderLanguageEntity
	 */
	public function hideOldByProviderLanguageEntity($feedProviderLanguageEntity) {
		$this->dbMapper->hideOldByProviderLanguageEntity($feedProviderLanguageEntity);
	}

	/**
	 * @param int $providerId
	 * @param int $languageId
	 * @return int
	 */
	public function getCountByProviderIdAndLanguageId($providerId, $languageId) {
		return $this->dbMapper->getCountByProviderIdAndLanguageId($providerId, $languageId);
	}
}
