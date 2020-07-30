<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class UserDomainRoleRepository extends BaseRepository {

	/** @var array */
	private $entitiesByUserId = array();

	/** @var array  */
	private $entitiesByDomainId = array();

	/**
	 * @param UserDomainRoleDbMapper $userDomainRoleDbMapper
	 */
	public function __construct(UserDomainRoleDbMapper $userDomainRoleDbMapper) {
		$this->dbMapper = $userDomainRoleDbMapper;
	}

	/**
	 * @param UserDomainRoleEntity[] $entities
	 */
	protected function cacheEntities(array $entities) {
		foreach ($entities as $entity) {
			$this->entitiesByUserId[$entity->getUserId()][$entity->getDomainId()] = $entity;
			$this->entitiesByDomainId[$entity->getDomainId()][$entity->getUserId()] = $entity;
		}
	}

	/**
	 * @param int $userId
	 * @param int $domainId
	 * @return UserDomainRoleEntity|null
	 */
	public function getByUserIdAndDomainId($userId, $domainId) {
		if (!isset($this->entitiesByUserId[$userId][$domainId])) {
			$entities = $this->find(array('user_id' => $userId, 'domain_id' => $domainId));
			$this->cacheEntities($entities);
		}
		return (isset($this->entitiesByUserId[$userId][$domainId]) ? $this->entitiesByUserId[$userId][$domainId] : null);
	}

	/**
	 * @param int $userId
	 * @return UserDomainRoleEntity[]|null
	 */
	public function findByUserId($userId) {
		if (!isset($this->entitiesByUserId[$userId])) {
			$entities = $this->find(array('user_id' => $userId));
			$this->cacheEntities($entities);
		}
		return (isset($this->entitiesByUserId[$userId]) ? $this->entitiesByUserId[$userId] : null);
	}

	/**
	 * @param UserDomainRoleEntity[] $entities
	 */
	public function saveEntities($entities) {
		$this->dbMapper->saveEntities($entities);
	}

	/**
	 * @param UserDomainRoleEntity[] $entities
	 */
	public function deleteEntities($entities) {
		$this->dbMapper->deleteEntities($entities);
	}

}