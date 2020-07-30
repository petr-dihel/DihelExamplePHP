<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Layout
 */
class ModulePageFeed_provider_detail extends Module {

	/**
	 * @var FeedProviderLanguageService
	 */
	private $feedProviderLanguageService;

	/**
	 * @var FeedProviderService
	 */
	private $feedProviderService;

	/**
	 * @var GET
	 */
	private $get;

	/**
	 * @var FeedProviderLanguageEntity
	 */
	private $providerLanguageEntity;

	/**
	 * @var LanguageService
	 */
	private $languageService;

	/**
	 * @var SmartForm
	 */
	private $smartForm;

	/**
	 * @var POST
	 */
	private $post;

	/**
	 * @var FeedProviderEntity
	 */
	private $feedProviderEntity;

	/**
	 * @var int
	 */
	private $selectedLanguageId = 0;

	/**
	 * @param FeedProviderLanguageService $feedProviderLanguageService
	 * @param FeedProviderService $feedProviderService
	 * @param GET $get
	 * @param POST $post
	 * @param LanguageService $languageService
	 */
	public function __construct(
		FeedProviderLanguageService $feedProviderLanguageService,
		FeedProviderService $feedProviderService,
		GET $get,
		POST $post,
		LanguageService $languageService
	) {
		$this->feedProviderLanguageService = $feedProviderLanguageService;
		$this->feedProviderService = $feedProviderService;
		$this->get = $get;
		$this->languageService = $languageService;
		$this->post = $post;
	}

	public function run() {
		$languageId = $this->get['language_id']->getInt();
		$this->selectedLanguageId = 0;
		$providerLanguageEntity = $this->feedProviderLanguageService->getByFeedProviderIdAndLanguageId(
			$this->render->id,
			$languageId
		);

		if (!is_null($providerLanguageEntity)) {
			$this->providerLanguageEntity = $providerLanguageEntity;
			if (!$this->isExistsParser($this->providerLanguageEntity->getFeedProviderEntity()->getName())) {
				$this->messageReporting->setErrorMessage('Parser for this provider does not exists');
			} else {
				$this->messageReporting->setInfoMessage('Parser for this provider exists ');
			}
		} else {
			$this->providerLanguageEntity = new FeedProviderLanguageEntity();
		}
		$this->initializeForm();
		$this->saveForm();
	}

	/**
	 * @param string $feedProviderName
	 * @return string
	 */
	private function getParserName($feedProviderName) {
		$parserName = sprintf(
			'FeedCategorization%sParser',
			ucfirst($feedProviderName)
		);
		return $parserName;
	}

	/**
	 * @param string $parserName
	 * @return bool
	 */
	private function isExistsParser($parserName) {
		$parserName = $this->getParserName($parserName);
		try {
			ServiceFactory::getInstance()->getServiceByName($parserName);
			return true;
		} catch (ServiceNotFoundException $exception) {
			return false;
		}
	}

	private function initializeForm() {
		$this->smartForm = new SmartForm('feed_provider');
		$this->smartForm->add('id');
		$this->smartForm->add('feed_provider_id');
		$this->smartForm->add('name', null);
		$this->smartForm->add('language_id', null, true);
		$this->smartForm->add('url', null, true);
		$this->smartForm->add('last_update');
		$this->smartForm->add('is_enabled');
	}

	/**
	 * @param string $providerName
	 * @return bool
	 */
	private function isExistsProviderName($providerName) {
		$feedProviders = $this->feedProviderService->findByFilter(
			array('name' => $providerName)
		);
		return !empty($feedProviders);
	}

	/**
	 * @param int $languageId
	 * @return bool
	 */
	private function isExistsProviderLanguage($languageId) {
		$providerLanguageEntity = $this->feedProviderLanguageService->getByFeedProviderIdAndLanguageId(
			$this->feedProviderEntity->getId(),
			$languageId
		);
		return !is_null($providerLanguageEntity);
	}

	/**
	 * @param string $name
	 * @return FeedProviderEntity|null|BaseEntity
	 */
	private function saveNewProviderEntity($name) {
		if ($this->isExistsProviderName($name)) {
			return null;
		} else {
			$providerEntity = new FeedProviderEntity();
			$providerEntity->setName($name);
			$providerEntity = $this->feedProviderService->insertNewEntity($providerEntity);
		}
		return $providerEntity;
	}

	/**
	 * @param int $feedProviderId
	 * @param string $name
	 * @return bool
	 */
	private function isLoadedFeedProvider($feedProviderId, $name) {
		if ($feedProviderId <= 0) {
			$this->feedProviderEntity = $this->saveNewProviderEntity($name);
		} else {
			$this->feedProviderEntity = $this->feedProviderService->getById($feedProviderId);
		}
		return !is_null($this->feedProviderEntity);
	}

	/**
	 * @param bool $isNewProvider
	 * @param bool $isNewLanguage
	 * @param int $languageId
	 * @param bool $isEnabled
	 * @param string $url
	 */
	private function saveProviderLanguage($isNewProvider, $isNewLanguage, $languageId, $isEnabled, $url) {
		if ($isNewLanguage && $this->isExistsProviderLanguage($languageId)) {
			$this->messageReporting->setErrorMessage(Localize::translate('feed_provider_language_exists'));
			return;
		}
		if ($isNewProvider) {
			Rewrite::generateUrl(
				Domain::getId(),
				'feed_provider_detail',
				$this->feedProviderEntity->getId(),
				$this->feedProviderEntity->getName(),
				'feed_provider_detail'
			);
		}
		$isEnabled = $isEnabled && $this->isExistsParser($this->feedProviderEntity->getName());
		$this->providerLanguageEntity->setFeedProviderId($this->feedProviderEntity->getId());
		$this->providerLanguageEntity->setLastUpdate(0);
		$this->providerLanguageEntity->setLanguageId($languageId);
		$this->providerLanguageEntity->setIsEnabled($isEnabled);
		$this->providerLanguageEntity->setUrl($url);
		$this->feedProviderLanguageService->saveEntities(array($this->providerLanguageEntity));
		$this->messageReporting->setInfoMessage(
			Localize::translate('feed_provider') . ' - ' . Localize::translate('saved')
		);
		$identUrl = Rewrite::getDefaultUrl(
			Domain::getId(),
			'feed_provider_detail',
			$this->providerLanguageEntity->getFeedProviderId()
		);
		SHOPSYS\Helpers\UrlHelper::redirectToPage($identUrl, array('language_id' => $languageId));
	}

	private function saveForm() {
		if ($this->smartForm->check_post()) {
			if ($this->smartForm->validate()) {
				$name = $this->post['name']->getString();
				$languageId = $this->post['language_id']->getString();
				$feedProviderId = $this->post['feed_provider_id']->getInt();
				$isNewFeedProvider = ($feedProviderId <= 0);
				$isEnabled = $this->post['is_enabled']->exists();
				$url = $this->post['url']->getString();
				$isNewLanguage = $this->post['is_new_language']->exists();
				if ($this->isLoadedFeedProvider($feedProviderId, $name)) {
					$this->saveProviderLanguage($isNewFeedProvider, $isNewLanguage, $languageId, $isEnabled, $url);
				} else {
					$this->messageReporting->setErrorMessage(Localize::translate('provider_name_exists'));
				}
			} else {
				foreach (SmartForm_Errors::getErrors() as $name => $item) {
					$this->messageReporting->setErrorMessage($name . ' - ' . $item['text']);
				}
			}
		}
	}

	/**
	 * @return FeedProviderEntity[]|array
	 */
	public function findProviderEntity() {
		return $this->feedProviderService->findAll();
	}

	/**
	 * @return FeedProviderLanguageEntity
	 */
	public function getProviderLanguageEntity() {
		return $this->providerLanguageEntity;
	}

	/**
	 * @return LanguageEntity[]|array
	 */
	public function findLanguagesEntity() {
		return $this->languageService->findAll();
	}

	/**
	 * @return int
	 */
	public function getSelectedLanguageId() {
		return $this->selectedLanguageId;
	}

}
