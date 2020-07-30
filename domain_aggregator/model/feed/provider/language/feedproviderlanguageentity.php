<?php

use \SHOPSYS\Helpers\NumberHelper;

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class FeedProviderLanguageEntity extends BaseEntity {

	use TLanguageId;
	use TLastUpdate;
	use TFeedProviderId;
	use TUrl;

	/**
	 * @var bool
	 */
	private $isEnabled = false;

	/**
	 * @return bool
	 */
	public function getIsEnabled() {
		return $this->isEnabled;
	}

	/**
	 * @param bool $isEnabled
	 * @return $this
	 */
	public function setIsEnabled($isEnabled) {
		$this->isEnabled = NumberHelper::parseBoolean($isEnabled);
		return $this;
	}

}
