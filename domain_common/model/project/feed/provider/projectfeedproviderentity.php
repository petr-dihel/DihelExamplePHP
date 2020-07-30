<?php

use \SHOPSYS\Helpers\NumberHelper;

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class ProjectFeedProviderEntity extends BaseEntity {

	use TProjectId;
	use TLanguageId;
	use TFeedProviderId;
	use TLastUpdate;

	/**
	 * @var string
	 */
	private $hash = '';

	/**
	 * @var bool
	 */
	private $isEnabled = false;

	/**
	 * @var int
	 */
	private $version = 0;

	/**
	 * @return string
	 */
	public function getHash() {
		return $this->hash;
	}

	/**
	 * @param string $hash
	 * @return $this
	 */
	public function setHash($hash) {
		$this->hash = (string)$hash;
		return $this;
	}

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

	/**
	 * @return int
	 */
	public function getVersion() {
		return $this->version;
	}

	/**
	 * @param int $version
	 * @return $this
	 */
	public function setVersion($version) {
		$this->version = (int)$version;
		return $this;
	}

}
