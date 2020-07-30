<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class FeedProviderValueEntity extends BaseEntity {

	use TId;
	use TFeedProviderId;

	/**
	 * @var string
	 */
	private $providerCatnum = '';

	/**
	 * @var int
	 */
	private $parentId = 0;

	/**
	 * @var bool
	 */
	private $isSetAble = false;

	/**
	 * @var string
	 */
	private $providerParentCatnum = '';

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
	public function getProviderParentCatnum() {
		return $this->providerParentCatnum;
	}

	/**
	 * @param bool $isSetAble
	 * @return $this
	 */
	public function setIsSetAble($isSetAble) {
		$this->isSetAble = (bool)$isSetAble;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function getIsSetAble() {
		return $this->isSetAble;
	}
}

