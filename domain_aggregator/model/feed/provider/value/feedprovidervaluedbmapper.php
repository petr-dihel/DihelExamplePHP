<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class FeedProviderValueDbMapper extends BaseAggregatorEntityDbMapper {

	/**
	 * @return FeedProviderValueEntity
	 */
	protected function createEntity() {
		return new FeedProviderValueEntity();
	}

	/**
	 * @return string
	 */
	protected function getTableName() {
		return "feed_provider_value";
	}

	/**
	 * @param array $where
	 * @return BaseEntity[]|array
	 */
	public function findByFeedProviderIdGroupByCatnum(array $where) {
		$query = $this->getPreparedQuery('*', $where);
		$resource = $this->database->query($query);
		$entities = array();
		while ($data = $this->database->fetchAssoc($resource)) {
			$entities[$data['provider_catnum']] = $this->mapEntity($this->createEntity(), $data);
		}
		return $entities;
	}
}