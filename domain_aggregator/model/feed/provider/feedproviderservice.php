<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class FeedProviderService extends BaseEntityService {

	/**
	 * @param FeedProviderRepository $repository
	 */
	public function __construct(FeedProviderRepository $repository) {
		$this->repository = $repository;
	}

	/**
	 * @param int $feedProviderId
	 * @return FeedProviderEntity|BaseEntity
	 */
	public function getById($feedProviderId) {
		return current($this->repository->find(array('id' => $feedProviderId)));
	}

}
