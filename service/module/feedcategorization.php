<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Service
 */
class FeedCategorization extends ServiceModule {

	/**
	 * @var FeedCategorizationGoogleParser|null
	 */
	private $feedCategorizationGoogleParser = null;

	/**
	 * @var FeedProviderLanguageService|null
	 */
	private $feedProviderLanguageService = null;

	/**
	 * @var FeedProviderImportDataService
	 */
	private $feedProviderImportDataService;

	/**
	 * @var FeedProviderService
	 */
	private $feedProviderService;

	/**
	 * @var FeedBaseParser|null
	 */
	private $parser = null;

	/**
	 * @var FeedProviderValueTranslateService
	 */
	private $feedProviderValueTranslateService;

	/**
	 * @var GET
	 */
	private $get;

	/**
	 * @param FeedCategorizationGoogleParser $feedCategorizationGoogleParser
	 * @param FeedProviderService $feedProviderService
	 * @param FeedProviderLanguageService $feedProviderLanguageService
	 * @param FeedProviderImportDataService $feedProviderImportDataService
	 * @param FeedProviderValueTranslateService $feedProviderValueTranslateService
	 * @param GET $get
	 */
	public function __construct(
		FeedCategorizationGoogleParser $feedCategorizationGoogleParser,
		FeedProviderService $feedProviderService,
		FeedProviderLanguageService $feedProviderLanguageService,
		FeedProviderImportDataService $feedProviderImportDataService,
		FeedProviderValueTranslateService $feedProviderValueTranslateService,
		GET $get
	) {
		$this->feedCategorizationGoogleParser = $feedCategorizationGoogleParser;
		$this->feedProviderLanguageService = $feedProviderLanguageService;
		$this->feedProviderImportDataService = $feedProviderImportDataService;
		$this->feedProviderService = $feedProviderService;
		$this->feedProviderValueTranslateService = $feedProviderValueTranslateService;
		$this->get = $get;
	}

	public function run() {
		$feedName = $this->get['feed']->getString();
		$languageId = $this->get['language_id']->getInt();
		if ($feedName != '' && $languageId > 0) {
			$feedProviderEntity = current($this->feedProviderService->findByFilter(array('name' => $feedName)));
			$feedProviderLanguageEntity = $this->feedProviderLanguageService
				->getByFeedProviderIdAndLanguageId($feedProviderEntity->getId(), $languageId);
			Service::log('Feed selected manually : ' . $feedName);
		} else {
			$feedProviderLanguageEntity = $this->feedProviderLanguageService->getEnabledOldestUpdated();
			$feedProviderEntity = $this->feedProviderService->getById(
				$feedProviderLanguageEntity->getFeedProviderId()
			);
		}

		Service::log(
			sprintf(
				'Feed provider id %d, languageId : %d, last updated: %d -  start ',
				$feedProviderLanguageEntity->getFeedProviderId(),
				$feedProviderLanguageEntity->getLanguageId(),
				$feedProviderLanguageEntity->getLastUpdate()
			)
		);

		$parserName = 'FeedCategorization' . ucfirst($feedProviderEntity->getName()) . 'Parser';
		try {
			$this->parser = ServiceFactory::getInstance()->getServiceByName($parserName);
		} catch (ServiceNotFoundException $exception) {
			Service::log('Parser not found : ' . var_export($parserName, true));
			return;
		}

		if (!$this->parser->downloadFile($feedProviderLanguageEntity)) {
			Service::log('Failed download source data url: ' . $feedProviderLanguageEntity->getUrl());
			return;
		}

		if ($this->parser->run()) {
			$feedProviderImportDataEntity = $this->parser->findAllFeedProviderImportDataEntity();
			Service::log('Loaded entities successfully count: ' . count($feedProviderImportDataEntity));
			$this->feedProviderImportDataService->saveEntities($feedProviderImportDataEntity);
			$this->feedProviderValueTranslateService->hideOldByProviderLanguageEntity($feedProviderLanguageEntity);
		} else {
			Service::log('Did not load any entities from url');
		}
		Service::log(
			sprintf('Feed provider id %d end', $feedProviderLanguageEntity->getFeedProviderId())
		);

		$feedProviderLanguageEntity->setLastUpdate(time());
		$this->feedProviderLanguageService->saveEntities(array($feedProviderLanguageEntity));
	}

}

