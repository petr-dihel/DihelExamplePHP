<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */ 
class FeedProviderLanguageRepository extends BaseRepository {

	/**
	 * @param FeedProviderLanguageDbMapper $dbMapper
	 */
	public function __construct(FeedProviderLanguageDbMapper $dbMapper) { 
		$this->dbMapper = $dbMapper;
	}

	/**
	 * @param int $feedProviderId
	 * @param int $languageId
	 * @return FeedProviderLanguageEntity|null
	 */
	public function getByFeedProviderIdAndLanguageId($feedProviderId, $languageId) {
		$where = array('feed_provider_id' => $feedProviderId, 'language_id' => $languageId);
		$entities = $this->dbMapper->find($where);
		return array_shift($entities);
	}

	/**
	 * @param FeedProviderLanguageEntity[] $entities
	 */
	public function saveEntities($entities) {
		$this->dbMapper->saveEntities($entities);
	}

	/**
	 * @param int $lastUpdate
	 * @return FeedProviderLanguageEntity[]|array
	 */
	public function findByLastUpdateOver($lastUpdate) {
		return $this->dbMapper->findByLastUpdateOver($lastUpdate);
	}
}
