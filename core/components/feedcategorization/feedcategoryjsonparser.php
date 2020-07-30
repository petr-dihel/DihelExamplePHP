<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class FeedCategoryJSONParser {

	/**
	 * @var string
	 */
	private $categorySeparator = ' | ';

	/**
	 * @var string
	 */
	private $catnumElementName = 'id';

	/**
	 * @var string
	 */
	private $nameElementName = 'name';

	/**
	 * @var string
	 */
	private $childrenElementName = 'children';

	/**
	 * @var FeedProviderImportDataEntity[]
	 */
	private $importData = array();

	/**
	 * @var int
	 */
	private $languageId = 0;

	/**
	 * @var int
	 */
	private $lastUpdate = 0;

	/**
	 * @var int
	 */
	private $feedProviderId = 0;

	/**
	 * @return FeedProviderImportDataEntity[]
	 */
	public function findAllFeedProviderImportDataEntity() {
		return $this->importData;
	}

	/**
	 * @param string $fileName
	 * @param FeedProviderLanguageEntity $feedProviderLanguageEntity
	 * @param int $time
	 */
	public function loadFromFile($fileName, $feedProviderLanguageEntity, $time) {
		$this->lastUpdate = $time;
		$this->languageId = $feedProviderLanguageEntity->getLanguageId();
		$this->feedProviderId = $feedProviderLanguageEntity->getFeedProviderId();
		$string = file_get_contents($fileName);
		$json = json_decode($string, true);
		foreach ($json as $category) {
			$this->loadCategory($category, '', '');
		}
	}

	/**
	 * @param array $category
	 * @return string
	 */
	private function getCategoryCatnum($category) {
		if (isset($category['id'])) {
			return $category['id'];
		}
		$categoryCatnum = 'generated_' . md5($category['name']);
		return $categoryCatnum;
	}

	/**
	 * @param array $category
	 * @param string $parentCatnum
	 * @param string $fullPath
	 */
	public function loadCategory($category, $parentCatnum, $fullPath) {
		$categoryCatnum = $this->getCategoryCatnum($category);
		if ($categoryCatnum != '') {
			$fullPath .= $this->categorySeparator . $category[$this->nameElementName];
			if (isset($category[$this->childrenElementName])) {
				foreach ($category[$this->childrenElementName] as $child) {
					$this->loadCategory($child, $categoryCatnum, $fullPath);
				}
			}
			$setAble = isset($this->catnumElementName);
			$importEntity = new FeedProviderImportDataEntity();
			$fullPath = trim($fullPath, $this->categorySeparator);
			$importEntity
				->setProviderCatnum($categoryCatnum)
				->setName($category[$this->nameElementName])
				->setFullPath($fullPath)
				->setProviderParentCatnum($parentCatnum)
				->setIsSetAble($setAble)
				->setIsVisible(true)
				->setFeedProviderId($this->feedProviderId)
				->setLanguageId($this->languageId)
				->setLastUpdate($this->lastUpdate);
			$this->importData[$categoryCatnum] = $importEntity;
		}
	}

	/**
	 * @param string $categorySeparator
	 * @return $this
	 */
	public function setCategorySeparator($categorySeparator) {
		$this->categorySeparator = (string)$categorySeparator;
		return $this;
	}

	/**
	 * @param string $catnumElementName
	 * @return $this
	 */
	public function setCatnumElementName($catnumElementName) {
		$this->catnumElementName = (string)$catnumElementName;
		return $this;
	}

	/**
	 * @param string $nameElementName
	 * @return $this
	 */
	public function setNameElementName($nameElementName) {
		$this->nameElementName = (string)$nameElementName;
		return $this;
	}

	/**
	 * @param string $childrenElementName
	 * @return $this
	 */
	public function setChildrenElementName($childrenElementName) {
		$this->childrenElementName = (string)$childrenElementName;
		return $this;
	}
}
