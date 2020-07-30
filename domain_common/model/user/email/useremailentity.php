<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class UserEmailEntity extends BaseEntity {

	use TUserId;

	/** @var string  */
	private $email = '';

	/** @var bool  */
	private $isDefaultForLogin = false;

	/** @var bool  */
	private $isContactEmail = false;

	/**
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @param string $email
	 * @return UserEmailEntity
	 */
	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function getIsDefaultForLogin() {
		return $this->isDefaultForLogin;
	}

	/**
	 * @param bool $isDefaultForLogin
	 * @return UserEmailEntity
	 */
	public function setIsDefaultForLogin($isDefaultForLogin) {
		$this->isDefaultForLogin = (bool)$isDefaultForLogin;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function getIsContactEmail() {
		return $this->isContactEmail;
	}

	/**
	 * @param bool $isContactEmail
	 * @return UserEmailEntity
	 */
	public function setIsContactEmail($isContactEmail) {
		$this->isContactEmail = (bool)$isContactEmail;
		return $this;
	}

}