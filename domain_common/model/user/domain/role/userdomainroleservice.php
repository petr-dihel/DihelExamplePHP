<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class UserDomainRoleService extends BaseService {

	/**
	 * @param UserDomainRoleRepository $userDomainRoleRepository
	 */
	public function __construct(UserDomainRoleRepository $userDomainRoleRepository) {
		$this->repository = $userDomainRoleRepository;
	}

	/**
	 * @param int $userId
	 * @param int $domainId
	 * @return UserDomainRoleEntity
	 */
	public function getByUserIdAndDomainId($userId, $domainId) {
		return $this->repository->getByUserIdAndDomainId($userId, $domainId);
	}

	/**
	 * @param int $userId
	 * @return UserDomainRoleEntity[]
	 */
	public function findByUserId($userId) {
		return $this->repository->findByUserId($userId);
	}

	/**
	 * @param UserDomainRoleEntity[] $entities
	 */
	public function saveEntities($entities) {
		$this->repository->saveEntities($entities);
	}

	/**
	 * @param UserDomainRoleEntity[] $entities
	 */
	public function deleteEntities($entities) {
		$this->repository->deleteEntities($entities);
	}

}