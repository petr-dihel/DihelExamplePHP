<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class FeedProviderValueTranslateEntity extends BaseEntity { 

	use TLanguageId;
	use TName;
	use TLastUpdate;

	/**
	 * @var int
	 */
	private $providerValueId = 0;

	/**
	 * @var string
	 */
	private $fullPath = '';

	/**
	 * @var bool
	 */
	private $isVisible = false;

	/**
	 * @return int
	 */
	public function getProviderValueId() {
		return $this->providerValueId;
	}

	/**
	 * @param int $providerValueId
	 * @return $this
	 */
	public function setProviderValueId($providerValueId) {
		$this->providerValueId = (int)$providerValueId;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getFullPath() {
		return $this->fullPath;
	}

	/**
	 * @param string $fullPath
	 * @return $this
	 */
	public function setFullPath($fullPath) {
		$this->fullPath = (string)$fullPath;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function getIsVisible() {
		return $this->isVisible;
	}

	/**
	 * @param bool $isVisible
	 * @return $this
	 */
	public function setIsVisible($isVisible) {
		$this->isVisible = (bool)$isVisible;
		return $this;
	}

}