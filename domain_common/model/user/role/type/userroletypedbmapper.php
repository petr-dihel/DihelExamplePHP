<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class UserRoleTypeDbMapper extends BaseCommonEntityDbMapper {

	/** @return UserRoleTypeEntity*/
	protected function createEntity() {
		return new UserRoleTypeEntity();
	}

	/** @return  string */
	protected function getTableName() {
		return 'user_role_type';
	}

}