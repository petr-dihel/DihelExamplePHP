<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */ 
class FeedProviderLanguageDbMapper extends BaseAggregatorEntityDbMapper {
 
	/**
	 * @return FeedProviderLanguageEntity
	 */
	protected function createEntity() {
		return new FeedProviderLanguageEntity();
	}

	/**
	 * @return string
	 */
	protected function getTableName() {
		return "feed_provider_language";
	}

	/**
	 * @param int $lastUpdate
	 * @return FeedProviderLanguageEntity[]|array
	 */
	public function findByLastUpdateOver($lastUpdate) {
		$resource = $this->database->prepareExecute(
			'SELECT *
			FROM `' . $this->getTableName() . '`
			WHERE `last_update` < ? ',
			$this->database->quoteSmart($lastUpdate)
		);
		$entities = array();
		while ($data = $this->database->fetchAssoc($resource)) {
			$entities[] = $this->mapEntity($this->createEntity(), $data);
		}
		return $entities;
	}
}
