<?php 
/**
 * @package ExampleDIhelPHP
* @subpackage Core
 */ 
class WorkPositionTranslateRepository extends BaseRepository {

	/** @var WorkPositionTranslateEntity[]|array*/
	private $cachedEntities = array();

	/**
	 * @param WorkPositionTranslateDbMapper $dbMapper
	 */
	public function __construct(WorkPositionTranslateDbMapper $dbMapper) { 
		$this->dbMapper = $dbMapper;
	}

	/**
	 * @param WorkPositionTranslateEntity[] $entities
	 */
	private function cacheEntities(array $entities) {
		foreach ($entities as $entity) {
			$this->cachedEntities[$entity->getWorkPositionId()][$entity->getLanguageId()] = $entity;
		}
	}

	/**
	 * @param int $workPositionId
	 * @param int $languageId
	 * @return WorkPositionTranslateEntity
	 */
	public function getByIdAndLanguageId($workPositionId, $languageId) {
		if (!isset($this->cachedEntities[$workPositionId][$languageId])) {
			$entities = $this->find(array('work_position_id' => $workPositionId));
			$this->cacheEntities($entities);
		}
		return $this->cachedEntities[$workPositionId][$languageId];
	}

	/**
	 * @param WorkPositionTranslateEntity[] $entities
	 */
	public function saveEntities($entities) {
		$this->dbMapper->saveEntities($entities);
	}

}