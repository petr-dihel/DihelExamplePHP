<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Layout
 */
class ModulePageProject_provider_detail extends Module {

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
	 * @var ProjectService
	 */
	private $projectService;

	/**
	 * @var GET
	 */
	private $get;

	/**
	 * @var ProjectFeedProviderEntity
	 */
	private $projectFeedProviderEntity;

	/**
	 * @var SmartForm
	 */
	private $smartForm;

	/**
	 * @var POST
	 */
	private $post;

	/**
	 * @param FeedProviderLanguageService $feedProviderLanguageService
	 * @param FeedProviderService $feedProviderService
	 * @param ProjectFeedProviderService $projectFeedProviderService
	 * @param ProjectService $projectService
	 * @param GET $get
	 * @param POST $post
	 */
	public function __construct(
		FeedProviderLanguageService $feedProviderLanguageService,
		FeedProviderService $feedProviderService,
		ProjectFeedProviderService $projectFeedProviderService,
		ProjectService $projectService,
		GET $get,
		POST $post
	) {
		$this->feedProviderLanguageService = $feedProviderLanguageService;
		$this->feedProviderService = $feedProviderService;
		$this->projectFeedProviderService = $projectFeedProviderService;
		$this->projectService = $projectService;
		$this->get = $get;
		$this->post = $post;
	}

	public function run() {
		$this->projectFeedProviderEntities = $this->projectFeedProviderService->findAll();
		$feedProviderId = $this->render->id;
		$projectId = $this->get['project_id']->getInt();
		$languageId = $this->get['language_id']->getInt();
		$this->projectFeedProviderEntity = $this->projectFeedProviderService
			->getByFeedProviderIdAndProjectIdAndLanguageId(
				$feedProviderId,
				$projectId,
				$languageId
			);
		if ($this->projectFeedProviderEntity == null) {
			$this->projectFeedProviderEntity = new ProjectFeedProviderEntity();
		}
		$this->initializeForm();
		$this->saveForm();
	}

	private function initializeForm() {
		$this->smartForm = new SmartForm('project_provider_detail');
		$this->smartForm->add('project_id', null, true);
		$this->smartForm->add('feed_provider_id', null, true);
		$this->smartForm->add('language_id', null, true);
		$this->smartForm->add('is_enabled');
		$this->smartForm->add('version');
		$this->smartForm->add('hash');
	}

	private function generateNewUrl() {
		$urlName = $this->projectFeedProviderEntity->getProject()->getKlientName()
			. '-' . $this->projectFeedProviderEntity->getFeedProviderEntity()->getName()
			. '-' . $this->projectFeedProviderEntity->getLanguage()->getSignature();
		Rewrite::generateUrl(
			Domain::getId(),
			'project_provider_detail',
			$this->projectFeedProviderEntity->getFeedProviderId(),
			$urlName,
			'project_provider_detail'
		);
	}

	private function redirectToSelf() {
		$identUrl = Rewrite::getDefaultUrl(
			Domain::getId(),
			'project_provider_detail',
			$this->projectFeedProviderEntity->getFeedProviderId()
		);
		SHOPSYS\Helpers\UrlHelper::redirectToPage(
			$identUrl,
			array(
				'language_id' => $this->projectFeedProviderEntity->getLanguageId(),
				'project_id' => $this->projectFeedProviderEntity->getProjectId()
			)
		);
	}

	private function loadErrorsFromSmartFormErrors() {
		foreach (SmartForm_Errors::getErrors() as $name => $item) {
			$this->messageReporting->setErrorMessage($name . ' - ' . $item['text']);
		}
	}

	private function saveForm() {
		if ($this->smartForm->check_post()) {
			if ($this->smartForm->validate()) {
				$projectId = $this->post['project_id']->getInt();
				$feedProviderId = $this->post['feed_provider_id']->getInt();
				$languageId = $this->post['language_id']->getInt();
				$isEnabled = $this->post['is_enabled']->exists();
				$version = $this->post['version']->getInt();
				$hash = $this->post['hash']->getString();
				$isNew = $this->post['is_new']->exists();
				$lastUpdate = $this->post['last_update']->getInt();
				$this->projectFeedProviderEntity
					->setProjectId($projectId)
					->setFeedProviderId($feedProviderId)
					->setLanguageId($languageId)
					->setLanguageId($isEnabled)
					->setIsEnabled($isEnabled)
					->setVersion($version)
					->setHash($hash)
					->setLastUpdate($lastUpdate);
				$this->projectFeedProviderService->saveEntities(array($this->projectFeedProviderEntity));
				if ($isNew) {
					$this->generateNewUrl();
					$this->messageReporting->setInfoMessage(Localize::translate('new_added_successfully'));
				} else {
					$this->messageReporting->setInfoMessage(Localize::translate('edited_successfully'));
				}
				$this->redirectToSelf();
			} else {
				$this->loadErrorsFromSmartFormErrors();
			}
		}
	}

	/**
	 * @return ProjectEntity[]
	 */
	public function findProjects() {
		return $this->projectService->findAll();
	}

	/**
	 * @return FeedProviderEntity[]|array|BaseEntity[]
	 */
	public function findFeedProviders() {
		return $this->feedProviderService->findAll();
	}

	/**
	 * @return ProjectFeedProviderEntity|null
	 */
	public function getProjectFeedProviderEntity() {
		return $this->projectFeedProviderEntity;
	}

	/**
	 * @return ProjectFeedProviderEntity[]
	 */
	public function getProjectFeedProviderEntities() {
		return $this->projectFeedProviderEntities;
	}

}
