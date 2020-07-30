<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class UserLoginActivityService extends BaseService {

	/**
	 * @param UserLoginActivityRepository $userLoginActivityRepository
	 */
	public function __construct(UserLoginActivityRepository $userLoginActivityRepository) {
		$this->repository = $userLoginActivityRepository;
	}

	/**
	 * @param int $userId
	 * @param string $userToken
	 * @param string $ident
	 * @return UserLoginActivityEntity
	 */
	public function getByUserIdAndUserTokenAndIdent($userId, $userToken, $ident) {
		$userLoginActivityEntities = $this->repository->find(
			array('user_id' => $userId, 'user_token' => $userToken, 'ident' => $ident)
		);
		return array_shift($userLoginActivityEntities);
	}

	/**
	 * @param int $userId
	 * @param string $userToken
	 * @param string $ident
	 */
	public function setUserTokenAndIdent($userId, $userToken, $ident) {
		$this->repository->setUserTokenAndIdent($userId, $userToken, $ident);
	}

}