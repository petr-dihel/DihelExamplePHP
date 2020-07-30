<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class UserLoginActivityEntity extends BaseEntity {

	use TUserId;

	/**
	 * @var string
	 */
	private $userToken;

	/**
	 * @var int
	 */
	private $tokenLastVerifyOn;

	/**
	 * @var int
	 */
	private $tokenExpireOn;

	/**
	 * @var string
	 */
	private $ident;

	/**
	 * @return string
	 */
	public function getUserToken() {
		return $this->userToken;
	}

	/**
	 * @param string $userToken
	 * @return UserLoginActivityEntity
	 */
	public function setUserToken($userToken) {
		$this->userToken = $userToken;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getTokenLastVerifyOn() {
		return $this->tokenLastVerifyOn;
	}

	/**
	 * @param int $tokenLastVerifyOn
	 * @return UserLoginActivityEntity
	 */
	public function setTokenLastVerifyOn($tokenLastVerifyOn) {
		$this->tokenLastVerifyOn = $tokenLastVerifyOn;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getTokenExpireOn() {
		return $this->tokenExpireOn;
	}

	/**
	 * @param int $tokenExpireOn
	 * @return UserLoginActivityEntity
	 */
	public function setTokenExpireOn($tokenExpireOn) {
		$this->tokenExpireOn = $tokenExpireOn;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getIdent() {
		return $this->ident;
	}

	/**
	 * @param string $ident
	 * @return UserLoginActivityEntity
	 */
	public function setIdent($ident) {
		$this->ident = $ident;
		return $this;
	}


}