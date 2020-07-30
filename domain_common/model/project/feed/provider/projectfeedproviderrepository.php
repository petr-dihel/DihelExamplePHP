<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */ 
class ProjectFeedProviderRepository extends BaseRepository {

	/**
	 * @param ProjectFeedProviderDbMapper $dbMapper
	 */
	public function __construct(ProjectFeedProviderDbMapper $dbMapper) { 
		$this->dbMapper = $dbMapper;
	}

	/**
	 * @param FeedProviderLanguageEntity[] $entities
	 */
	public function saveEntities($entities) {
		$this->dbMapper->saveEntities($entities);
	}
}
