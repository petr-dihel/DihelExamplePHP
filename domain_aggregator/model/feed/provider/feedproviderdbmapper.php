<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class FeedProviderDbMapper extends BaseAggregatorEntityDbMapper {

	/**
	 * @return FeedProviderEntity
	 */
	protected function createEntity() {
		return new FeedProviderEntity();
	}

	/**
	 * @return string
	 */
	protected function getTableName() {
		return "feed_provider";
	}

}