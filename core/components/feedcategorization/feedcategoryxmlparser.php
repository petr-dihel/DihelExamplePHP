<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class FeedCategoryXmlParser {

	/**
	 * @var string
	 */
	private $catnumElementName = 'CATEGORY_ID';

	/**
	 * @var string
	 */
	private $nameElementName = 'CATEGORY_NAME';

	/**
	 * @var string
	 */
	private $fullPathElementName = 'CATEGORY_FULLNAME';

	/**
	 * @var SimpleXMLElement
	 */
	private $categoryElements = array();

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
	 * @param string $fileName
	 * @param string $pathToCategory
	 * @param FeedProviderLanguageEntity $feedProviderLanguageEntity
	 * @param int $time
	 */
	public function loadFromFile($fileName, $pathToCategory, $feedProviderLanguageEntity, $time) {
		$this->categoryElements = simplexml_load_file($fileName, 'SimpleXmlElement', 0, $pathToCategory);
		$this->lastUpdate = $time;
		$this->languageId = $feedProviderLanguageEntity->getLanguageId();
		$this->feedProviderId = $feedProviderLanguageEntity->getFeedProviderId();
		foreach ($this->categoryElements as $node) {
			$this->loadCategoryByNode($node, '');
		}
	}

	/**
	 * @return FeedProviderImportDataEntity[]
	 */
	public function findAllFeedProviderImportDataEntity() {
		return $this->importData;
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
	 * @param string $fullPathElementName
	 * @return $this
	 */
	public function setFullPathElementName($fullPathElementName) {
		$this->fullPathElementName = (string)$fullPathElementName;
		return $this;
	}

	/**
	 * @param SimpleXMLElement $node
	 * @param string $elementName
	 * @return string
	 */
	private function getNodeElement($node, $elementName) {
		$elements = $node->xpath($elementName);
		return (
			$elements != false
			? (string)current($elements)
			: ''
		);
	}

	/**
	 * @param SimpleXMLElement $node
	 * @param string $parentCatnum
	 */
	private function loadCategoryByNode($node, $parentCatnum) {
		$categoryCatnum = $this->getNodeElement($node, $this->catnumElementName);

		if ($categoryCatnum != '') {
			if ($node->count() > 0) {
				foreach ($node->children() as $child) {
					$this->loadCategoryByNode($child, $categoryCatnum);
				}
			}
			$categoryName = $this->getNodeElement($node, $this->nameElementName);
			$categoryFullPath = $this->getNodeElement($node, $this->fullPathElementName);
			$setAble = ($categoryFullPath != '');
			$importEntity = new FeedProviderImportDataEntity();
			$importEntity
				->setProviderCatnum($categoryCatnum)
				->setName($categoryName)
				->setFullPath($categoryFullPath)
				->setProviderParentCatnum($parentCatnum)
				->setIsSetAble($setAble)
				->setIsVisible(true)
				->setFeedProviderId($this->feedProviderId)
				->setLanguageId($this->languageId)
				->setLastUpdate($this->lastUpdate);
			$this->importData[$categoryCatnum] = $importEntity;
		}
	}

}
