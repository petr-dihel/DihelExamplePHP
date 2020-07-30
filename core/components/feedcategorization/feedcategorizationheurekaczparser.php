<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class FeedCategorizationHeurekaCzParser extends FeedBaseParser implements FeedParserInterface {

	/**
	 * @var FeedCategoryXmlParser
	 */
	private $feedCategoryXmlParser = null;

	/**
	 * @param CurlDownloadFactory $curlDownloadFactory
	 * @param FeedCategoryXmlParser $feedCategoryXmlParser
	 */
	public function __construct(
		CurlDownloadFactory $curlDownloadFactory,
		FeedCategoryXmlParser $feedCategoryXmlParser
	) {
		parent::__construct($curlDownloadFactory);
		$this->feedCategoryXmlParser = $feedCategoryXmlParser;
	}

	/**
	 * @return FeedProviderImportDataEntity[]
	 */
	public function findAllFeedProviderImportDataEntity() {
		return $this->cachedEntities;
	}

	/**
	 * @return bool
	 */
	public function run() {
		$this->feedCategoryXmlParser->loadFromFile(
			$this->fileName,
			'',
			$this->feedProviderLanguageEntity,
			$this->actualTime
		);
		$this->cachedEntities = $this->feedCategoryXmlParser->findAllFeedProviderImportDataEntity();
		return (count($this->cachedEntities) > 0);
	}
}
