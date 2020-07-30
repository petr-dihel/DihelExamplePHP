<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Layout
 */
class ModulePageFeed_providers extends Module {

	/**
	 * @var string
	 */
	 const URL_TO_SERVICE = 'service/service.php?module=feedcategorization';

	/**
	 * @var FeedProviderLanguageService
	 */
	private $feedProviderLanguageService;

	/**
	 * @var FeedProviderService
	 */
	private $feedProviderService;

	/**
	 * @param FeedProviderLanguageService $feedProviderLanguageService
	 * @param FeedProviderService $feedProviderService
	 */
	public function __construct(
		FeedProviderLanguageService $feedProviderLanguageService,
		FeedProviderService $feedProviderService
	) {

		$this->feedProviderLanguageService = $feedProviderLanguageService;
		$this->feedProviderService = $feedProviderService;
	}

	public function run() {
	}

	/**
	 * @param FeedProviderLanguageEntity $feedProviderLanguageService
	 * @return string
	 */
	public function getServiceUrlByProviderLanguageEntity($feedProviderLanguageService) {
		$url = Domain::getUrl() . self::URL_TO_SERVICE;
		$moduleName = $feedProviderLanguageService->getFeedProviderEntity()->getName();
		$languageId = $feedProviderLanguageService->getLanguageId();
		$url .= '&feed=' . $moduleName . '&language_id=' . $languageId . '&debug=1';
		return $url;
	}

	/**
	 * @return FeedProviderLanguageEntity[]|array
	 */
	public function getFeedProvidersLanguages() {
		return $this->feedProviderLanguageService->findAll();
	}
}
