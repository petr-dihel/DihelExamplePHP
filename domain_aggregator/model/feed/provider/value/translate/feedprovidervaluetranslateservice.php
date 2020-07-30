<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class FeedProviderValueTranslateService extends BaseService {

	/**
	 * @param FeedProviderValueTranslateRepository $repository
	 */
	public function __construct(FeedProviderValueTranslateRepository $repository) {
		$this->repository = $repository;
	}

	/**
	 * @param FeedProviderValueTranslateEntity[] $entities
	 */
	public function saveEntities($entities) {
		$this->repository->saveEntities($entities);
	}

	/**
	 * @param FeedProviderImportDataEntity $entity
	 * @return FeedProviderValueTranslateEntity
	 */
	public function getProviderValueTranslateEntityByImportDataEntity($entity) {
		$providerValueTranslate = new FeedProviderValueTranslateEntity();
		$providerValueTranslate
			->setProviderValueId($entity->getProviderValueId())
			->setLanguageId($entity->getLanguageId())
			->setName($entity->getName())
			->setFullPath($entity->getFullPath())
			->setLastUpdate($entity->getLastUpdate())
			->setIsVisible($entity->getIsVisible());
		return $providerValueTranslate;
	}

	/**
	 * @param FeedProviderLanguageEntity $feedProviderLanguageEntity
	 */
	public function hideOldByProviderLanguageEntity($feedProviderLanguageEntity) {
		$this->repository->hideOldByProviderLanguageEntity($feedProviderLanguageEntity);
	}

	/**
	 * @param int $providerId
	 * @param int $languageId
	 * @return int
	 */
	public function getCountByProviderIdAndLanguageId($providerId, $languageId) {
		return $this->repository->getCountByProviderIdAndLanguageId($providerId, $languageId);
	}
}
