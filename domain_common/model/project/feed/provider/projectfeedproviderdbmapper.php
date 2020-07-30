<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class ProjectFeedProviderDbMapper extends BaseAggregatorEntityDbMapper {

	/**
	 * @return ProjectFeedProviderEntity
	 */
	protected function createEntity() {
		return new ProjectFeedProviderEntity();
	}

	/**
	 * @return string
	 */
	protected function getTableName() {
		return "project_feed_provider";
	}

}
