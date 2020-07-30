<?php

use SHOPSYS\Helpers\NumberHelper;

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class FeedProviderImportDataEntity extends BaseEntity {

	use TId;
	use TFeedProviderId;
	use TLanguageId;
	use TName;
	use TLastUpdate;

	/**
	 * @var int
	 */
	private $providerValueId = 0;

	/**
	 * @var int
	 */
	private $parentId = 0;

	/**
	 * @var bool
	 */
	private $isVisible = false;

	/**
	 * @var string
	 */
	private $providerCatnum = '';

	/**
	 * @var string
	 */
	private $providerParentCatnum = '';

	/**
	 * @var string
	 */
	private $fullPath = '';

	/**
	 * @var string
	 */
	private $parentFullPath = '';

	/**
	 * @var bool
	 */
	private $isSetAble = true;

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
	 * @return int
	 */
	public function getParentId() {
		return $this->parentId;
	}

	/**
	 * @param int $parentId
	 * @return $this
	 */
	public function setParentId($parentId) {
		$this->parentId = (int)$parentId;
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
		$this->isVisible = NumberHelper::parseBoolean($isVisible);
		return $this;
	}

	/**
	 * @return string
	 */
	public function getProviderCatnum() {
		return $this->providerCatnum;
	}

	/**
	 * @param string $providerCatnum
	 * @return $this
	 */
	public function setProviderCatnum($providerCatnum) {
		$this->providerCatnum = (string)$providerCatnum;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getProviderParentCatnum() {
		return $this->providerParentCatnum;
	}

	/**
	 * @param string $providerParentCatnum
	 * @return $this
	 */
	public function setProviderParentCatnum($providerParentCatnum) {
		$this->providerParentCatnum = (string)$providerParentCatnum;
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
	 * @return string
	 */
	public function getParentFullPath() {
		return $this->parentFullPath;
	}

	/**
	 * @param string $parentFullPath
	 * @return $this
	 */
	public function setParentFullPath($parentFullPath) {
		$this->parentFullPath = (string)$parentFullPath;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function getIsSetAble() {
		return $this->isSetAble;
	}

	/**
	 * @param bool $isSetAble
	 * @return $this
	 */
	public function setIsSetAble($isSetAble) {
		$this->isSetAble = (bool)$isSetAble;
		return $this;
	}

}

