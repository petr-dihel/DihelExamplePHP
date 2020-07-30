<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class UserDbMapper extends BaseCommonEntityDbMapper {

	/** @return string */
	protected function getTableName() {
		return 'user';
	}

	/** @return UserEntity */
	protected function createEntity() {
		return new UserEntity();
	}

	/**
	 * @param string $filter
	 * @return int
	 */
	public function getUsersCount($filter) {
		$resource = $this->database->prepareExecute("
			SELECT COUNT(DISTINCT(U.`user_id`))
			FROM `users` AS U
			JOIN `companies` AS C ON U.`company_id` = C.`id` AND C.`datetime_removed` = ?
			LEFT JOIN `image_gallery` AS IG ON U.`user_id` = IG.`object_id`
			LEFT JOIN `companies_translate` AS CT ON U.`company_id` = CT.`company_id`
			" . $filter,
			SHOPSYS\Helpers\DatetimeHelper::DATABASE_EMPTY_DATETIME
		);

		if ($this->database->rows($resource) > 0) {
			return (int)$this->database->fetchValue($resource);
		}
		return 0;
	}

	/**
	 * @param string $filter
	 * @param string $orderBy
	 * @param int $limit
	 * @param int $offset
	 * @return UserEntity[]
	 */
	public function findUsersByPagingEntity($filter, $orderBy, $limit, $offset) {
		$collection = array();

		$resource = $this->database->prepareExecute("
			SELECT
				U.`user_id`, U.`company_id`,
				U.`work_position_id`, U.`title_before`, U.`title_after`,
				U.`name`, U.`surname`, U.`email`,
				U.`phone`, U.`is_hired`
			FROM `" . $this->getTableName() . "` AS U
			" . $filter . "
			GROUP BY U.`user_id`
			ORDER BY " . $orderBy . "
			LIMIT " . $offset . ", " . $limit,
			SHOPSYS\Helpers\DatetimeHelper::DATABASE_EMPTY_DATETIME
		);

		if ($this->database->rows($resource) > 0) {
			while ($row = $this->database->fetchAssoc($resource)) {
				/** @var UserEntity $userEntity */
				$userEntity = $this->mapEntity(new UserEntity(), $row);
				$collection[$userEntity->getId()] = $userEntity;
			}
		}

		return $collection;
	}

}
