<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class ProjectFeedProviderService extends BaseService {

	/**
	 * @param ProjectFeedProviderRepository $repository
	 */
	public function __construct(ProjectFeedProviderRepository $repository) {
		$this->repository = $repository;
	}

	/**
	 * @param int $feedProviderId
	 * @param int $projectId
	 * @param int $languageId
	 * @return ProjectFeedProviderEntity|BaseEntity
	 */
	public function getByFeedProviderIdAndProjectIdAndLanguageId($feedProviderId, $projectId, $languageId) {
		$projectFeedProviderEntities = $this->repository->find(
			array(
				'feed_provider_id' => $feedProviderId,
				'project_id' => $projectId,
				'language_id' => $languageId
			)
		);
		return current($projectFeedProviderEntities);
	}

	/**
	 * @return ProjectFeedProviderEntity[]|array|BaseEntity
	 */
	public function findAll() {
		return $this->repository->findAll();
	}

	/**
	 * @param FeedProviderLanguageEntity[] $entities
	 */
	public function saveEntities($entities) {
		$this->repository->saveEntities($entities);
	}
}
