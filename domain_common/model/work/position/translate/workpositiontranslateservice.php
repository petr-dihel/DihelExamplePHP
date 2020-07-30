<?php

/**
 * @package ExampleDIhelPHP
* @subpackage Core
 */ 
class WorkPositionTranslateService extends BaseService {

	/**
	 * @param WorkPositionTranslateRepository $repository
	 */
	public function __construct(WorkPositionTranslateRepository $repository) {
		$this->repository = $repository;
	}

	/**
	 * @param int $workPositionId
	 * @param int $languageId
	 * @return WorkPositionEntity
	 */
	public function getWorkPositionTranslateByWorkPositionIdAndLanguageId($workPositionId, $languageId) {
		$entities = $this->repository->find(array('work_position_id' => $workPositionId, 'language_id' => $languageId));
		return array_shift($entities);
	}

	/**
	 * @param int $workPositionId
	 * @return WorkPositionEntity[]
	 */
	public function getWorkPositionTranslateByWorkPositionId($workPositionId) {
		return $this->repository->find(array('work_position_id' => $workPositionId));
	}

	/**
	 * @param WorkPositionTranslateEntity[] $entities
	 */
	public function saveEntities($entities) {
		$this->repository->saveEntities($entities);
	}

}