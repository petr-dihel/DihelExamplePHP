<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class FeedProviderLanguageService extends BaseService {

	/**
	 * @param FeedProviderLanguageRepository $repository
	 */
	public function __construct(FeedProviderLanguageRepository $repository) {
		$this->repository = $repository;
	}

	/***
	 * @param int $providerId
	 * @return FeedProviderLanguageEntity[]|array|BaseEntity[]
	 */
	public function findByProviderId($providerId) {
		return $this->repository->find(array('feed_provider_id' => $providerId));
	}

	/**
	 * @param int $feedProviderId
	 * @param int $languageId
	 * @return FeedProviderLanguageEntity|null
	 */
	public function getByFeedProviderIdAndLanguageId($feedProviderId, $languageId) {
		return $this->repository->getByFeedProviderIdAndLanguageId($feedProviderId, $languageId);
	}

	/**
	 * @return FeedProviderLanguageEntity[]|array|BaseEntity
	 */
	public function findAll() {
		return $this->repository->findAll();
	}

	/**
	 * @return FeedProviderLanguageEntity|BaseEntity
	 */
	public function getEnabledOldestUpdated() {
		return current($this->repository->find(array('is_enabled' => 1), array('last_update ASC'), 1));
	}

	/**
	 * @param FeedProviderLanguageEntity[] $entities
	 */
	public function saveEntities($entities) {
		$this->repository->saveEntities($entities);
	}

	/**
	 * @param int $lastUpdate
	 * @return FeedProviderLanguageEntity[]|array
	 */
	public function findByLastUpdateOver($lastUpdate) {
		return $this->repository->findByLastUpdateOver($lastUpdate);
	}
}
