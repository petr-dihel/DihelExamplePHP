<?php

/**
 * Interface FeedParserInterface
 */
interface FeedParserInterface {

	/**
	 * @return FeedProviderImportDataEntity[]
	 */
	public function findAllFeedProviderImportDataEntity();

	/**
	 * @return bool
	 */
	public function run();

}

