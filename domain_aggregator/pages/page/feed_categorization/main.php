<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Layout
 */
class ModulePageFeed_categorization extends Module {

	/**
	 * @var int
	 */
	const LAST_UPDATE_WARNING_LIMIT = 3600 * 24;

	/**
	 * @var FeedProviderService
	 */
	private $feedProviderService;

	/**
	 * @var FeedProviderLanguageService
	 */
	private $feedProviderLanguageService;

	/**
	 * @var FeedProviderValueService
	 */
	private $feedProviderValueService;

	/**
	 * @var FeedProviderValueTranslateService
	 */
	private $feedProviderValueTranslateService;

	/**
	 * @var FeedProviderLanguageEntity[]
	 */
	private $feedProviderLanguageEntities = array();

	/**
	 * @var string[]|array
	 */
	private $feedProviderTitles = array();

	/**
	 * @var int[]|array
	 */
	private $feedProviderGraphValues = array();

	/**
	 * ModulePageFeed_categorization constructor.
	 * @param FeedProviderService $feedProviderService
	 * @param FeedProviderLanguageService $feedProviderLanguageService
	 * @param FeedProviderValueService $feedProviderValueService
	 * @param FeedProviderValueTranslateService $feedProviderValueTranslateService
	 */
	public function __construct(
		FeedProviderService $feedProviderService,
		FeedProviderLanguageService $feedProviderLanguageService,
		FeedProviderValueService $feedProviderValueService,
		FeedProviderValueTranslateService $feedProviderValueTranslateService
	) {

		$this->feedProviderService = $feedProviderService;
		$this->feedProviderLanguageService = $feedProviderLanguageService;
		$this->feedProviderValueService = $feedProviderValueService;
		$this->feedProviderValueTranslateService = $feedProviderValueTranslateService;
	}

	public function run() {
		$this->feedProviderLanguageEntities = $this->feedProviderLanguageService->findAll();
		$this->initialize();
	}

	private function initialize() {
		$lastUpdateLimit = time() - self::LAST_UPDATE_WARNING_LIMIT;
		foreach ($this->feedProviderLanguageEntities as $entity) {
			if ($entity->getIsEnabled()) {
				$this->feedProviderTitles[] = $this->getFeedProviderLanguageTitle($entity);

				$this->feedProviderGraphValues[] = $this->feedProviderValueTranslateService
					->getCountByProviderIdAndLanguageId(
						$entity->getFeedProviderId(),
						$entity->getLanguageId()
					);
				if ($entity->getLastUpdate() < $lastUpdateLimit) {
					$message = sprintf(
						"%s %s - %s",
						$this->getFeedProviderLanguageTitle($entity),
						Localize::translate('is_old'),
						date('j.n.Y H:i:s', $entity->getLastUpdate())
					);
					$this->messageReporting->setErrorMessage($message);
				}

			}

		}
	}

	/**
	 * @param FeedProviderLanguageEntity $entity
	 * @return string
	 */
	private function getFeedProviderLanguageTitle($entity) {
		$message = '';
		if (!is_null($entity->getFeedProviderEntity()) && !is_null($entity->getLanguage())) {
			$message = sprintf(
				"%s - %s",
				$entity->getFeedProviderEntity()->getName(),
				$entity->getLanguage()->getSignature()
			);
		}
		return $message;
	}

	/**
	 * @return string
	 */
	public function getFeedProvidersNames() {
		$json = json_encode($this->feedProviderTitles);
		return $json;
	}

	/**
	 * @return string
	 */
	public function getFeedProviderValueTranslateCount() {
		$json = json_encode($this->feedProviderGraphValues);
		return $json;
	}

}
