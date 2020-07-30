<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
abstract class FeedBaseParser implements FeedParserInterface {

	/**
	 * @var string
	 */
	const PATH_TO_FILE = '/db/feed_categorization/%s_%s.txt';

	/**
	 * @var CurlDownload
	 */
	protected $curlDownload = null;

	/**
	 * @var FeedProviderImportDataEntity[]
	 */
	protected $cachedEntities = array();

	/**
	 * @var int
	 */
	protected $actualTime = 0;

	/**
	 * @var FeedProviderLanguageEntity
	 */
	protected $feedProviderLanguageEntity = null;

	/**
	 * @var string
	 */
	protected $fileName = '';

	/**
	 * @param CurlDownloadFactory $curlDownloadFactory
	 */
	public function __construct(CurlDownloadFactory $curlDownloadFactory) {
		$this->curlDownload = $curlDownloadFactory->create();
		$this->actualTime = time();
	}

	/**
	 * @return FeedProviderImportDataEntity[]
	 */
	public function findAllFeedProviderImportDataEntity() {
		return $this->cachedEntities;
	}

	/**
	 * @param FeedProviderLanguageEntity $feedProviderLanguageEntity
	 * @return bool
	 */
	public function downloadFile($feedProviderLanguageEntity) {
		$this->feedProviderLanguageEntity = $feedProviderLanguageEntity;
		$languageSignature = $this->feedProviderLanguageEntity->getLanguage()->getSignature();
		$feedName = $this->feedProviderLanguageEntity->getFeedProviderEntity()->getName();
		$this->fileName = ROOT_DIR . sprintf(self::PATH_TO_FILE, $feedName, $languageSignature);
		$filePointer = fopen($this->fileName, 'w+');
		$this->feedProviderLanguageEntity->getFeedProviderId();
		$this->curlDownload->setFilePointer($filePointer);
		$response = $this->curlDownload->getDownloadByUrl($this->feedProviderLanguageEntity->getUrl());
		fclose($filePointer);
		return ($response != false);
	}

}
