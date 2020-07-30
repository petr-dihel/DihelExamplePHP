<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class UserDomainRoleEntity extends BaseEntity {

	use TUserId;
	use TDomainId;

	/**
	 * @var int
	 */
	private $userRoleTypeId;

	/**
	 * @return int
	 */
	public function getUserRoleTypeId() {
		return $this->userRoleTypeId;
	}

	/**
	 * @param int $userRoleTypeId
	 * @return UserDomainRoleEntity
	 */
	public function setUserRoleTypeId($userRoleTypeId) {
		$this->userRoleTypeId = $userRoleTypeId;
		return $this;
	}

	/**
	 * @return UserRoleTypeEntity
	 */
	public function getUserRoleType() {
		return ServiceFactory::getInstance()->getServiceByName(UserRoleTypeService::getName())
			->findById($this->userRoleTypeId);
	}

}