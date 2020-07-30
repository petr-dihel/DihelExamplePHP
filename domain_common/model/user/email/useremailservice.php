<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class UserEmailService extends BaseService {

	/** @var UserEmailRepository */
	protected $repository;

	/**
	 * @param UserEmailRepository $repository
	 */
	public function __construct(UserEmailRepository $repository) {
		$this->repository = $repository;
	}

	/**
	 * @param int $userId
	 * @return UserEmailEntity[]|array
	 */
	public function findUserEmailsByUserId($userId) {
		return $this->repository->findUserEmailsByUserId($userId);
	}

	/**
	 * @param int $userId
	 * @return UserEmailEntity
	 */
	public function getUserLogInEmail($userId) {
		return $this->repository->getUserLogInEmail($userId);
	}

	/**
	 * @param int $userId
	 * @return UserEmailEntity
	 */
	public function getUserContactEmail($userId) {
		return $this->repository->getUserContactEmail($userId);
	}

	/**
	 * @param string $email
	 * @return UserEmailEntity
	 */
	public function getUserIdByLoginEmail($email) {
		return $this->repository->getByLoginEmail($email);
	}

	/**
	 * @param UserEmailEntity[] $entities
	 */
	public function saveEntities($entities) {
		$this->repository->saveEntities($entities);
	}

	/**
	 * @param UserEmailEntity[] $entities
	 */
	public function deleteEntities($entities) {
		$this->repository->deleteEntities($entities);
	}
}