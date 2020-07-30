<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Layout
 */
class ModuleAjaxFeed_provider_languages_versions extends Module {

	/**
	 * @var FeedProviderLanguageService
	 */
	private $feedProviderLanguageService;

	/**
	 * @var FeedProviderService
	 */
	private $feedProviderService;

	/**
	 * @var POST
	 */
	private $post;

	/**
	 * @var FeedProviderEntity[]
	 */
	private $languagesEntities = array();

	/**
	 * @var int
	 */
	private $selectedLanguageId = 0;

	/**
	 * ModuleAjaxFeed_provider_languages_versions constructor.
	 * @param FeedProviderLanguageService $feedProviderLanguageService
	 * @param FeedProviderService $feedProviderService
	 * @param POST $post
	 */
	public function __construct(
		FeedProviderLanguageService $feedProviderLanguageService,
		FeedProviderService $feedProviderService,
		POST $post
	) {
		$this->feedProviderLanguageService = $feedProviderLanguageService;
		$this->feedProviderService = $feedProviderService;
		$this->post = $post;
	}

	public function run() {
		$providerId = $this->post['feedProviderId']->getInt();
		$this->selectedLanguageId = $this->post['selectedLanguageId']->getInt();
		if ($providerId > 0) {
			$feedProviderLanguagesEntities = $this->feedProviderLanguageService->findByProviderId($providerId);
			foreach ($feedProviderLanguagesEntities as $entity) {
				$this->languagesEntities[] = $entity->getLanguage();
			}
		}
	}

	/**
	 * @return FeedProviderEntity[]
	 */
	public function findProviderLanguageEntity() {
		return $this->languagesEntities;
	}

	/**
	 * @return int
	 */
	public function getSelectedLanguageId() {
		return $this->selectedLanguageId;
	}

}

