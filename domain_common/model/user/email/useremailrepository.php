<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class UserEmailRepository extends BaseRepository {

	/** @var array */
	private $entitiesByUserId = array();

	/**
	 * @param UserEmailDbMapper $userEmailDbMapper
	 */
	public function __construct(UserEmailDbMapper $userEmailDbMapper) {
		$this->dbMapper = $userEmailDbMapper;
	}

	/**
	 * @param UserEmailEntity[] $entities
	 */
	protected function cacheEntities(array $entities) {
		foreach ($entities as $entity) {
			if ($entity->getIsContactEmail()) {
				$this->entitiesByUserId[$entity->getUserId()]['is_contact_email'] = $entity;
			}
			if ($entity->getIsDefaultForLogin()) {
				$this->entitiesByUserId[$entity->getUserId()]['is_default_for_login'] = $entity;
			}
			$this->entitiesByUserId[$entity->getUserId()][] = $entity;
		}
	}

	/**
	 * @param int $userId
	 * @return UserEmailEntity[]|array
	 */
	public function findUserEmailsByUserId($userId) {
		$entities = $this->find(array('user_id' => $userId));
		$this->cacheEntities($entities);
		return $entities;
	}

	/**
	 * @param int $userId
	 * @return UserEmailEntity
	 */
	public function getUserLogInEmail($userId) {
		if (!isset($this->entitiesByUserId[$userId]['is_default_for_login'])) {
			$entities = $this->find(array('user_id' => $userId, 'is_default_for_login' => 1));
			$this->cacheEntities($entities);
		}

		return (
			isset($this->entitiesByUserId[$userId]['is_default_for_login'])
			? $this->entitiesByUserId[$userId]['is_default_for_login']
			: null
		);
	}

	/**
	 * @param int $userId
	 * @return UserEmailEntity
	 */
	public function getUserContactEmail($userId) {
		if (!isset($this->entitiesByUserId[$userId]['is_contact_email'])) {
			$entities = $this->find(array('user_id' => $userId, 'is_contact_email' => 1));
			$this->cacheEntities($entities);
		}

		return (
			isset($this->entitiesByUserId[$userId]['is_contact_email'])
			? $this->entitiesByUserId[$userId]['is_contact_email']
			: null
		);
	}

	/**
	 * @param string $email
	 * @return UserEmailEntity
	 */
	public function getByLoginEmail($email) {
		$userEmailEntity = $this->find(array('email' => $email, 'is_default_for_login' => 1));
		$this->cacheEntities($userEmailEntity);
		return array_shift($userEmailEntity);
	}

	/**
	 * @param UserEmailEntity[] $entities
	 */
	public function saveEntities($entities) {
		$this->dbMapper->saveEntities($entities);
	}

	/**
	 * @var UserEmailEntity[] $entities
	 */
	public function deleteEntities($entities) {
		$this->dbMapper->deleteEntities($entities);
	}

}