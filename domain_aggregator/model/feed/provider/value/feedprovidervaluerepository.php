<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class FeedProviderValueRepository extends BaseRepository {

	/**
	 * @param FeedProviderValueDbMapper $dbMapper
	 */
	public function __construct(FeedProviderValueDbMapper $dbMapper) {
		$this->dbMapper = $dbMapper;
	}

	/**
	 * @param FeedProviderValueEntity[] $entities
	 */
	public function saveEntities($entities) {
		$this->dbMapper->saveEntities($entities);
	}

	/**
	 * @param array $where
	 * @return FeedProviderValueEntity[]|array
	 */
	public function findByFeedProviderIdGroupByCatnum($where) {
		return $this->dbMapper->findByFeedProviderIdGroupByCatnum($where);
	}

}