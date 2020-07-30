<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class UserEmailDbMapper extends BaseCommonDbMapper {

	/** @return  UserEmailEntity */
	protected function createEntity() {
		return new UserEmailEntity();
	}

	/** @return  string */
	protected function getTableName() {
		return 'user_email';
	}

}