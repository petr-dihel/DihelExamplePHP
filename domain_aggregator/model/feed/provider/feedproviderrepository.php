<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class FeedProviderRepository extends BaseEntityRepository {

	/**
	 * @param FeedProviderDbMapper $dbMapper
	 */
	public function __construct(FeedProviderDbMapper $dbMapper) {
		$this->dbMapper = $dbMapper;
	}
}