<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class UserRoleTypeEntity extends BaseEntity {

	const USER = 'user';
	const ADMIN = 'admin';
	const DEVELOPER = 'developer';

	use TId;
	use TDomainId;
	use TName;

}