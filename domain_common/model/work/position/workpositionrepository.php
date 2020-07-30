<?php

use SHOPSYS\Helpers\ArrayHelper;

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class WorkPositionRepository extends BaseEntityRepository {

	/** @var LanguageService */
	private $languageService;

	/** @var WorkPositionEntity[] */
	private $cache = null;

	/**
	 * @param WorkPositionDbMapper $workPositionDbMapper
	 * @param LanguageService $languageService
	 */
	public function __construct(
		WorkPositionDbMapper $workPositionDbMapper, LanguageService $languageService
	) {
		$this->dbMapper = $workPositionDbMapper;
		$this->languageService = $languageService;
	}

	/**
	 * Vrátí seznam pracovních pozic,
	 * kde ID pozice bude první index a ID jazyka druhý index
	 *
	 * @return WorkPositionEntity[]|array
	 */
	public function getAllWorkPositions() {
		if (is_null($this->cache)) {
			$this->loadAll();
		}

		return $this->cache;
	}

	/**
	 * @param int $languageId
	 * @return WorkPositionEntity[]|null
	 */
	public function getAvailableWorkPositionsByLanguageId($languageId) {
		$languageIndexes = $this->languageService->findAllLanguageIds();
		if (ArrayHelper::isInArray($languageId, $languageIndexes)) {
			return $this->workPositionDbMapper->getAvailableWorkPositionsByLanguageId($languageId);
		}
		return null;
	}

	/**
	 * @return WorkPositionEntity[]
	 */
	public function getAllWorkPositionsLangIdPrimary() {
		$collection = array();
		$workPositions = $this->getAllWorkPositions();

		foreach ($workPositions as $entityId => $workPosition) {
			foreach ($workPosition as $langId => $entity) {
				$collection[$langId][$entityId] = $entity;
			}
		}

		return $collection;
	}

	/**
	 * @param int $id
	 * @return WorkPositionEntity
	 */
	public function getWorkPositionById($id) {
		if (is_null($this->cache)) {
			$this->loadAll();
		}

		return ArrayHelper::isKeyExist($this->cache, $id) ? $this->cache[$id] : null;
	}

	/**
	 *
	 * @param PagingEntity $pagingEntity
	 * @return WorkPositionEntity[]|array
	 */
	public function getWorkPositions($pagingEntity) {
		$offset = $pagingEntity->getRowsPerPage() * $pagingEntity->getPageId();
		$limit = $pagingEntity->getRowsPerPage();
		$orderBy = $pagingEntity->getConditions();
		$filter =
			(empty($pagingEntity->getFilterConditions()))
			? ""
			: "WHERE " . $pagingEntity->getFilterConditions();

		return $this->workPositionDbMapper->getWorkPositions($filter, $orderBy, $limit, $offset);
	}

	/**
	 * @param PagingEntity $pagingEntity
	 * @return int
	 */
	public function getCount($pagingEntity) {
		$filter =
			(empty($pagingEntity->getFilterConditions()))
			? ""
			: "WHERE " . $pagingEntity->getFilterConditions();

		return $this->workPositionDbMapper->getCount($filter);
	}

	/**
	 * @param WorkPositionEntity $entity
	 */
	public function save($entity) {
		if (is_null($this->cache)) {
			$this->loadAll();
		}
		if (ArrayHelper::isKeyExist($this->cache, $entity->getId())) {
			$this->cache[$entity->getId()][$entity->getLanguageId()] = $entity;
			$this->workPositionDbMapper->save($entity);
		} else {
			$adminLanguages = ServiceFactory::getInstance()->getLanguageService()->getIdsOfAdminLanguages();
			foreach ($adminLanguages as $languageId) {
				$entity->setLanguageId($languageId);
				$this->cache[$entity->getId()][$entity->getLanguageId()] = $entity;
				$this->workPositionDbMapper->save($entity);
			}
		}
	}

	/**
	 * @param int $id
	 */
	public function delete($id) {
		$this->workPositionDbMapper->delete($id);
	}

	private function loadAll() {
		$this->cache = $this->workPositionDbMapper->getAll();
	}
}
