<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class WorkPositionService extends BaseEntityService {

	/**
	 * @param WorkPositionRepository $workPositionRepository
	 */
	public function __construct(WorkPositionRepository $workPositionRepository) {
		$this->repository = $workPositionRepository;
	}

	/**
	 * @return WorkPositionEntity[]
	 */
	public function findAll() {
		return $this->repository->findAll();
	}

	/**
	 * @return WorkPositionEntity[]|array
	 */
	public function findAvailableWorkPositions() {
		return $this->repository->find(array('is_available' => 1));
	}

	/**
	 * @param int $workPositionId
	 * @return WorkPositionEntity
	 */
	public function getById($workPositionId) {
		return $this->repository->getById($workPositionId);
	}

	/**
	 * @param PagingEntity $pagingEntity
	 * @return int
	 */
	public function getCount($pagingEntity) {
		return $this->repository->getCount($pagingEntity);
	}

	/**
	 * @param PagingEntity $pagingEntity
	 * @return WorkPositionEntity[]|array
	 */
	public function findWorkPositions($pagingEntity) {
		return $this->repository->getWorkPositions($pagingEntity);
	}

	/**
	 * @param WorkPositionEntity[] $workPositionEntity
	 */
	public function save($workPositionEntity) {
		$this->repository->saveEntities($workPositionEntity);
	}

	/**
	 * @param int $workPositionId
	 */
	public function delete($workPositionId) {
		$this->repository->delete($workPositionId);
	}
}
