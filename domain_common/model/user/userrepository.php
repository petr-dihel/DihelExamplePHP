<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class UserRepository extends BaseEntityRepository {

	/**
	 * @param UserDbMapper $userDbMapper
	 */
	public function __construct(UserDbMapper $userDbMapper) {
		$this->dbMapper = $userDbMapper;
	}

	/**
	 * @param PagingEntity $pagingEntity
	 * @return int
	 */
	public function getUsersCount($pagingEntity) {
		$filter = (
			(empty($pagingEntity->getFilterConditions()))
			? ""
			: "WHERE " . $pagingEntity->getFilterConditions()
		);

		return $this->dbMapper->getUsersCount($filter);
	}

	/**
	 * @param PagingEntity $pagingEntity
	 * @return UserEntity[]
	 */
	public function findUsersByPagingEntity($pagingEntity) {
		$offset = $pagingEntity->getRowsPerPage() * $pagingEntity->getPageId();
		$limit = $pagingEntity->getRowsPerPage();
		$orderBy = $pagingEntity->getConditions();
		$filter = (
			(empty($pagingEntity->getFilterConditions()))
			? ""
			: "WHERE " . $pagingEntity->getFilterConditions()
		);

		return $this->dbMapper->findUsersByPagingEntity($filter, $orderBy, $limit, $offset);
	}

}
