<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class FeedCategorizationZboziParser extends FeedBaseParser implements FeedParserInterface {

	/**
	 * @var FeedCategoryJSONParser
	 */
	private $categoryJSONParser;

	/**
	 * @param FeedCategoryJSONParser $categoryJSONParser
	 * @param CurlDownloadFactory $curlDownloadFactory
	 */
	public function __construct(
		FeedCategoryJSONParser $categoryJSONParser,
		CurlDownloadFactory $curlDownloadFactory
	) {
		parent::__construct($curlDownloadFactory);
		$this->categoryJSONParser = $categoryJSONParser;
	}

	/**
	 * @return bool
	 */
	public function run() {
		$this->categoryJSONParser->loadFromFile($this->fileName, $this->feedProviderLanguageEntity, $this->actualTime);
		$this->cachedEntities = $this->categoryJSONParser->findAllFeedProviderImportDataEntity();
		return (count($this->cachedEntities) > 0);
	}

}
