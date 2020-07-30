<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Layout
 */
class ModulePageProjects_providers extends Module {

	/**
	 * @var FeedProviderLanguageService
	 */
	private $feedProviderLanguageService;

	/**
	 * @var FeedProviderService
	 */
	private $feedProviderService;

	/**
	 * @var ProjectFeedProviderEntity[]
	 */
	private $projectFeedProviderEntities = array();

	/**
	 * @var ProjectFeedProviderService
	 */
	private $projectFeedProviderService;

	/**
	 * @param FeedProviderLanguageService $feedProviderLanguageService
	 * @param FeedProviderService $feedProviderService
	 * @param ProjectFeedProviderService $projectFeedProviderService
	 */
	public function __construct(
		FeedProviderLanguageService $feedProviderLanguageService,
		FeedProviderService $feedProviderService,
		ProjectFeedProviderService $projectFeedProviderService
	) {

		$this->feedProviderLanguageService = $feedProviderLanguageService;
		$this->feedProviderService = $feedProviderService;
		$this->projectFeedProviderService = $projectFeedProviderService;
	}

	public function run() {
		$this->projectFeedProviderEntities = $this->projectFeedProviderService->findAll();
	}

	/**
	 * @return ProjectFeedProviderEntity[]
	 */
	public function getProjectFeedProviderEntities() {
		return $this->projectFeedProviderEntities;
	}

}
