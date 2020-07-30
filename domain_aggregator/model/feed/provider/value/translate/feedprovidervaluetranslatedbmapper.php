<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class FeedProviderValueTranslateDbMapper extends BaseAggregatorEntityDbMapper {

	/**
	 * @return FeedProviderValueTranslateEntity
	 */
	protected function createEntity() {
		return new FeedProviderValueTranslateEntity();
	}

	/**
	 * @return string
	 */
	protected function getTableName() {
		return "feed_provider_value_translate";
	}

	/**
	 * @param FeedProviderLanguageEntity $feedProviderLanguageEntity
	 */
	public function hideOldByProviderLanguageEntity($feedProviderLanguageEntity) {
		$this->database->prepareExecute(
			'UPDATE `' . $this->getTableName() . '`
				SET `is_visible` = 0
			WHERE `provider_value_id` = ? 
				AND `last_update` < ?',
			$feedProviderLanguageEntity->getFeedProviderId(),
			$feedProviderLanguageEntity->getLastUpdate()
		);
	}

	/**
	 * @param int $providerId
	 * @param int $languageId
	 * @return int
	 */
	public function getCountByProviderIdAndLanguageId($providerId, $languageId) {
		return (int)$this->database->prepareExecuteValue(
			'SELECT COUNT(FPVT.`provider_value_id`)
			FROM `' . $this->getTableName() . '` FPVT
			JOIN `feed_provider_value` FPV ON FPV.`id` = FPVT.`provider_value_id`
			WHERE FPV.`feed_provider_id` = ?
				AND FPVT.`language_id` = ?
			',
			$providerId,
			$languageId
		);
	}
}
