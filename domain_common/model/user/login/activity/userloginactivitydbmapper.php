<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class UserLoginActivityDbMapper extends BaseCommonDbMapper {

	/** @return UserLoginActivityEntity*/
	protected function createEntity() {
		return new UserLoginActivityEntity();
	}

	/** @return  string */
	protected function getTableName() {
		return 'user_login_activity';
	}

	/**
	 * @param int $userId
	 * @param string $userToken
	 * @param string $ident
	 */
	public function setUserTokenAndIdent($userId, $userToken, $ident) {
		$time = time();
		$expireTime = $time + Auth::LOGIN_EXPIRATION_TIME;
		$this->database->prepareExecute(
			'INSERT INTO ' . $this->getTableName() . '
				(`user_id`, `user_token`, `token_last_verify_on`, `token_expire_on`, `ident`)
			VALUES (?, ?, ?, ?, ?)
			ON DUPLICATE KEY UPDATE `token_last_verify_on` = VALUES(`token_last_verify_on`),
				`token_expire_on` = VALUES(`token_expire_on`)',
			$userId,
			$userToken,
			$time,
			$expireTime,
			$ident
		);
	}

}