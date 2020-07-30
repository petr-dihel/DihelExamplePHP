<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class UserRoleTypeRepository extends BaseEntityRepository {

	/**
	 * @param UserRoleTypeDbMapper $userRoleTypeDbMapper
	 */
	public function __construct(UserRoleTypeDbMapper $userRoleTypeDbMapper) {
		$this->dbMapper = $userRoleTypeDbMapper;
	}

}