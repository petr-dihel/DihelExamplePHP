<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class UserService extends BaseService {

	/** @var UserEmailService  */
	private $userEmailService;

	/** @var UserDomainRoleService */
	private $userDomainRoleService;

	/** @var UserLoginActivityService */
	private $userLoginActivityService;

	/**
	 * @var WorkPositionService
	 */
	private $positionService;

	/**
	 * @var CompanyService
	 */
	private $companyService;

	/**
	 * @param UserRepository $userRepository
	 * @param UserEmailService $userEmailService
	 * @param UserDomainRoleService $userDomainRoleService
	 * @param UserLoginActivityService $userLoginActivityService
	 * @param WorkPositionService $positionService
	 * @param CompanyService $companyService
	 */
	public function __construct(
		UserRepository $userRepository,
		UserEmailService $userEmailService,
		UserDomainRoleService $userDomainRoleService,
		UserLoginActivityService $userLoginActivityService,
		WorkPositionService $positionService,
		CompanyService $companyService
	) {
		$this->repository = $userRepository;
		$this->userEmailService = $userEmailService;
		$this->userDomainRoleService = $userDomainRoleService;
		$this->userLoginActivityService = $userLoginActivityService;
		$this->positionService = $positionService;
		$this->companyService = $companyService;
	}

	/**
	 * @param int $userId
	 * @param int $domainId
	 * @return UserDomainRoleEntity
	 */
	public function getUserRolesByDomain($userId, $domainId) {
		return $this->userDomainRoleService->getByUserIdAndDomainId($userId, $domainId);
	}

	/**
	 * @param PagingEntity $pagingEntity
	 * @return int
	 */
	public function getUsersCount($pagingEntity) {
		return $this->repository->getUsersCount($pagingEntity);
	}

	/**
	 * @param PagingEntity $pagingEntity
	 * @return UserEntity[]
	 */
	public function getUsers($pagingEntity) {
		$users = $this->repository->findUsersByPagingEntity($pagingEntity);
		return $this->processImages($users);
		return $users;
	}

	/**
	 * @return array|UserEntity[]
	 */
	public function getAllUsers() {
		return $this->repository->findAll();
	}

	/**
	 * @param int $id
	 * @return UserEntity|BaseEntity
	 */
	public function getById($id) {
		return $this->repository->getById($id);
	}

	/**
	 * @param string $userToken
	 * @param string $email
	 * @param string $ident
	 * @return UserEntity
	 */
	public function getUserByIdTokenAndEmailAndIdent($userToken, $email, $ident) {
		$userEntity = $this->getByLogInEmail($email);
		if (!is_null($userEntity)) {
			$userLoginActivity = $this->userLoginActivityService->getByUserIdAndUserTokenAndIdent(
				$userEntity->getId(),
				$userToken,
				$ident
			);
			if (!is_null($userLoginActivity)) {
				return $this->getById($userLoginActivity->getUserId());
			}
		}
		return null;
	}

	/**
	 * @param string $email
	 * @return UserEntity
	 */
	public function getByLogInEmail($email) {
		$userEntity = null;
		$userEmailEntity = $this->userEmailService->getUserIdByLoginEmail($email);
		if (!is_null($userEmailEntity)) {
			$userEntity = $this->getById($userEmailEntity->getUserId());
		}
		return $userEntity;
	}

	/**
	 * @param string $userId
	 * @param string $userToken
	 * @param string $ident
	 */
	public function setUserTokenAndIdent($userId, $userToken, $ident) {
		$this->userLoginActivityService->setUserTokenAndIdent($userId, $userToken, $ident);
	}

	/**
	 * @param UserEntity $entity
	 */
	public function save($entity) {
		$this->repository->saveEntities(array($entity));
	}

	/**
	 * @param int $userId
	 * @param int $domainId
	 * @return UserDomainRoleEntity
	 */
	public function getUserRoleByDomainAndUserId($userId, $domainId) {
		return $this->userDomainRoleService->getByUserIdAndDomainId($userId, $domainId);
	}

	/**
	 * @param int $userId
	 * @return UserDomainRoleEntity[]|array
	 */
	public function findUserRoleByUserId($userId) {
		return $this->userDomainRoleService->findByUserId($userId);
	}

	/**
	 * @param UserEntity[] $users
	 * @return UserEntity[]|array
	 */
	private function processImages($users) {
		/** @todo upravit obrázky do modelu */
		/*
		$galleryService = ServiceFactory::getInstance()->getGalleryService();

		foreach ($users as $user) {
			$userImages = $galleryService->getAllUserImages($user->getUserId());
			$user->setProfileImage(array_values($userImages)[0]);
			$user->setImages($userImages);

			if (ArrayHelper::isKeyExist($userImages, 0) && $userImages[0]->isDefault()) {
				// Pokud se jedna o uzivatele bez vlastni profilove fotky
				$user->setIsPhoto(false);
			} else {
				$user->setIsPhoto(true);
			}
		}*/

		return $users;
	}
}
