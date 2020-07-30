<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class FeedProviderImportDataService {

	/**
	 * @var FeedProviderValueService
	 */
	private $feedProviderValueService;

	/**
	 * @var FeedProviderValueTranslateService
	 */
	private $feedProviderValueTranslateService;

	/**
	 *
	 * @param FeedProviderValueService $feedProviderValueService
	 * @param FeedProviderValueTranslateService $feedProviderValueTranslateService
	 */
	public function __construct(
		FeedProviderValueService $feedProviderValueService,
		FeedProviderValueTranslateService $feedProviderValueTranslateService
	) {

		$this->feedProviderValueService = $feedProviderValueService;
		$this->feedProviderValueTranslateService = $feedProviderValueTranslateService;
	}

	/**
	 * @param FeedProviderImportDataEntity[] $entities
	 * @return FeedProviderValueEntity[]|array
	 */
	private function findProviderValueByCatnum($entities) {
		$entity = (is_array($entities) ? current($entities) : null);
		$feedProviderId = ($entity instanceof BaseEntity ? $entity->getFeedProviderId() : 0);
		return $this->feedProviderValueService->findByFeedProviderIdGroupByCatnum($feedProviderId);
	}

	/**
	 * @param FeedProviderImportDataEntity[] $entities
	 */
	private function loadParentsToEntities($entities) {
		$entitiesToSave = array();
		$providerValueEntities = $this->findProviderValueByCatnum($entities);
		foreach ($providerValueEntities as $providerValueEntity) {
			$parentCatnum = $providerValueEntity->getProviderParentCatnum();
			if ($parentCatnum !== '' && isset($providerValueEntities[$parentCatnum])) {
				$parentEntity = $providerValueEntities[$parentCatnum];
				$providerValueEntity->setParentId($parentEntity->getId());
				$entitiesToSave[] = $providerValueEntity;
			}
		}
		$this->feedProviderValueService->saveEntities($entitiesToSave);
	}

	/**
	 * @param FeedProviderImportDataEntity[] $entities
	 */
	private function saveProviderValuesTranslate($entities) {
		$providerValueTranslateEntities = array();
		$providerValuesEntities = $this->findProviderValueByCatnum($entities);
		foreach ($entities as $item) {
			$providerValueTranslateEntity = $this->feedProviderValueTranslateService
				->getProviderValueTranslateEntityByImportDataEntity($item);
			$providerValueEntity = $this->feedProviderValueService
				->getProviderValueEntityByImportDataEntity($item);
			$providerValueId = $providerValuesEntities[$providerValueEntity->getProviderCatnum()]->getId();
			$providerValueTranslateEntity->setProviderValueId($providerValueId);
			$providerValueTranslateEntities[] = $providerValueTranslateEntity;
		}
		$this->feedProviderValueTranslateService->saveEntities($providerValueTranslateEntities);
	}

	/**
	 * @param FeedProviderImportDataEntity[] $entities
	 */
	private function saveProviderValues($entities) {
		$providerValuesToSave = array();
		$oldProviderValuesEntities = $this->findProviderValueByCatnum($entities);

		foreach ($entities as $hashedFullName => $entity) {
			$providerValue = $this->feedProviderValueService
				->getProviderValueEntityByImportDataEntity($entity);
			$providerCatnum = $providerValue->getProviderCatnum();
			if (isset($oldProviderValuesEntities[$providerCatnum])) {
				$providerValueId = $oldProviderValuesEntities[$providerCatnum]->getId();
				$providerValue->setId($providerValueId);
				unset($oldProviderValuesEntities[$providerCatnum]);
			}
			$providerValuesToSave[] = $providerValue;
		}
		$this->feedProviderValueService->saveEntities($providerValuesToSave);

	}

	/**
	 * @param FeedProviderImportDataEntity[] $entities
	 */
	public function saveEntities($entities) {
		$this->saveProviderValues($entities);
		$this->loadParentsToEntities($entities);
		$this->saveProviderValuesTranslate($entities);
	}
}