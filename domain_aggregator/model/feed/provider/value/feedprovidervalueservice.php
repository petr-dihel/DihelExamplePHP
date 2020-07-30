<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class FeedProviderValueService extends BaseService {

	/**
	 * @param FeedProviderValueRepository $repository
	 */
	public function __construct(FeedProviderValueRepository $repository) {
		$this->repository = $repository;
	}

	/**
	 * @param FeedProviderValueEntity[] $entities
	 */
	public function saveEntities($entities) {
		$this->repository->saveEntities($entities);
	}

	/**
	 * @param int $feedProviderId
	 * @return FeedProviderValueEntity[]|array
	 */
	public function findByFeedProviderIdGroupByCatnum($feedProviderId) {
		return $this->repository->findByFeedProviderIdGroupByCatnum(
			array('feed_provider_id' => $feedProviderId)
		);
	}

	/**
	 * @param FeedProviderImportDataEntity $entity
	 * @return FeedProviderValueEntity
	 */
	public function getProviderValueEntityByImportDataEntity($entity) {
		$providerValue = new FeedProviderValueEntity();
		$providerValue
			->setFeedProviderId($entity->getFeedProviderId())
			->setProviderCatnum($entity->getProviderCatnum())
			->setParentId($entity->getParentId())
			->setProviderParentCatnum($entity->getProviderParentCatnum())
			->setIsSetAble($entity->getIsSetAble());
		return $providerValue;
	}

}