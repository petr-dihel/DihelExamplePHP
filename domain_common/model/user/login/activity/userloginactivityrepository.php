<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class UserLoginActivityRepository extends BaseRepository {

	/**
	 * @param UserLoginActivityDbMapper $userLoginActivityDbMapper
	 */
	public function __construct(UserLoginActivityDbMapper $userLoginActivityDbMapper) {
		$this->dbMapper = $userLoginActivityDbMapper;
	}

	/**
	 * @param int $userId
	 * @param string $userToken
	 * @param string $ident
	 */
	public function setUserTokenAndIdent($userId, $userToken, $ident) {
		$this->dbMapper->setUserTokenAndIdent($userId, $userToken, $ident);
	}

}