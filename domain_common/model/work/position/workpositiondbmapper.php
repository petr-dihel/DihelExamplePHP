<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class WorkPositionDbMapper extends BaseCommonEntityDbMapper {

	/** @return WorkPositionEntity */
	protected function createEntity() {
		return new WorkPositionEntity();
	}

	/** @return string */
	protected function getTableName() {
		return 'work_position';
	}

	/**
	 *
	 * @param string $filter
	 * @param string $orderBy
	 * @param int $limit
	 * @param int $offset
	 * @return WorkPositionEntity|array
	 */
	public function findWorkPositions($filter, $orderBy, $limit, $offset) {
		$collection = array();
		$resource = $this->database->prepareExecute(
			"SELECT WP.`id`, WP.`available`
			FROM `" . $this->getTableName() . "` AS WP
			" . $filter . "
			ORDER BY " . $orderBy . "
			LIMIT " . $offset . ", " . $limit
		);

		if ($this->database->rows($resource) > 0) {
			while ($row = $this->database->fetchAssoc($resource)) {
				$entity = $this->createEntity();
				$entity = $this->mapEntity($entity, $row);
				$collection[$entity->getId()] = $entity;
			}
		}

		return $collection;
	}

	/**
	 * @param int $languageId
	 * @return WorkPositionEntity[]
	 */
	public function getAvailableWorkPositionsByLanguageId($languageId) {
		$collection = array();

		$resource = $this->database->prepareExecute(
			"SELECT WP.`id`, WP.`available`
			FROM `" . $this->getTableName() . "` AS WP
			WHERE WP.`available` = 1 AND WP.`datetime_removed` = ?",
			$languageId, SHOPSYS\Helpers\DatetimeHelper::DATABASE_EMPTY_DATETIME
		);

		if ($this->database->rows($resource) > 0) {
			while ($row = $this->database->fetchAssoc($resource)) {
				$entity = $this->createEntity();
				$entity = $this->mapEntity($entity, $row);
				$collection[$entity->getId()] = $entity;
			}
		}

		return $collection;
	}

	/**
	 * @param string $filter
	 * @return int
	 */
	public function getCount($filter) {
		$count = 0;
		$resource = $this->database->prepareExecute("
			SELECT COUNT(WP.`id`)
			FROM `" . $this->getTableName() . "` AS WP
			" . $filter
		);

		if ($this->database->rows($resource) > 0) {
			$count = $this->database->fetchValue($resource);
		}

		return $count;
	}

	/**
	 * @param int $id
	 */
	public function delete($id) {
		$this->database->prepareExecute(
			"UPDATE `" . $this->getTableName() . "` SET `datetime_removed` = NOW() WHERE `id` = ?", $id
		);
	}

}
