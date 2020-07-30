<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class UserRoleTypeService extends BaseEntityService {

	/**
	 * @param UserRoleTypeRepository $userRoleTypeRepository
	 */
	public function __construct(UserRoleTypeRepository $userRoleTypeRepository) {
		$this->repository = $userRoleTypeRepository;
	}

}