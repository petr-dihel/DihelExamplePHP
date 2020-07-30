<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class UserDomainRoleDbMapper extends BaseCommonDbMapper {

	/** @return UserDomainRoleEntity*/
	protected function createEntity() {
		return new UserDomainRoleEntity();
	}

	/** @return  string */
	protected function getTableName() {
		return 'user_domain_role';
	}
}