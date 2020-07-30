<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class UserEntity extends BaseEntity {

	use TId;
	use TCompanyId;
	use TName;

	/** @var int */
	private $workPositionId = 0;

	/** @var string */
	private $titleBefore = '';

	/** @var string */
	private $titleAfter = '';

	/** @var string */
	private $surname = '';

	/** @var string */
	private $phone = '';

	/** @var bool */
	private $isHired = false;

	/** @var bool */
	private $isSuperAdmin;

	/**
	 * @return bool
	 */
	public function getIsSuperAdmin() {
		\SHOPSYS\Helpers\NumberHelper::parseFloat()
		return $this->isSuperAdmin;
	}

	/**
	 * @param bool $isSuperAdmin
	 * @return UserEntity
	 */
	public function setIsSuperadmin($isSuperAdmin) {
		$this->isSuperAdmin = (bool)$isSuperAdmin;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getWorkPositionId() {
		return $this->workPositionId;
	}

	/**
	 * @param int $id
	 * @return $this
	 */
	public function setWorkPositionId($id) {
		$this->workPositionId = (int)$id;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getTitleBefore() {
		return $this->titleBefore;
	}

	/**
	 * @param string $title
	 * @return $this
	 */
	public function setTitleBefore($title) {
		$this->titleBefore = (string)$title;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getTitleAfter() {
		return $this->titleAfter;
	}

	/**
	 * @param string $title
	 * @return $this
	 */
	public function setTitleAfter($title) {
		$this->titleAfter = (string)$title;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getSurname() {
		return $this->surname;
	}

	/**
	 * @param string $surname
	 * @return $this
	 */
	public function setSurname($surname) {
		$this->surname = (string)$surname;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPhone() {
		return $this->phone;
	}

	/**
	 * @param string $phone
	 * @return $this
	 */
	public function setPhone($phone) {
		$this->phone = (string)$phone;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function getIsHired() {
		return $this->isHired;
	}

	/**
	 * @param bool $isHired
	 * @return $this
	 */
	public function setIsHired($isHired) {
		$this->isHired = (bool)$isHired;
		return $this;
	}

	/**
	 * @return UserEmailEntity[]
	 */
	public function findEmails() {
		$userEmailService = ServiceFactory::getInstance()->getServiceByName(UserEmailService::getName());
		return $userEmailService->findUserEmailsByUserId($this->getId());
	}

	/**
	 * @return UserEmailEntity
	 */
	public function getContactEmail() {
		$userEmailService = ServiceFactory::getInstance()->getServiceByName(UserEmailService::getName());
		return $userEmailService->getUserContactEmail($this->getId());
	}

	/**
	 * @return UserEmailEntity
	 */
	public function getLoginEmail() {
		$userEmailService = ServiceFactory::getInstance()->getServiceByName(UserEmailService::getName());
		return $userEmailService->getUserLoginEmail($this->getId());
	}

}
