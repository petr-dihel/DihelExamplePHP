<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class FeedCategorizationGoogleParser extends FeedBaseParser implements FeedParserInterface {

	/**
	 * @var string
	 */
	const GOOGLE_SEPARATOR = '>';

	/**
	 * @param string $string
	 * @return string
	 */
	private function getTrimmedString($string) {
		return trim((string)$string);
	}

	/**
	 * @param string $fullPath
	 * @param int $positionOfLastButOneSeparator
	 * @param int $positionOfLastCategorySeparator
	 * @return string
	 */
	private function getParentFullPath($fullPath, $positionOfLastButOneSeparator, $positionOfLastCategorySeparator) {
		$parent = '';
		if ($positionOfLastButOneSeparator > 0) {
			$unTrimmedParent = substr(
				$fullPath,
				0,
				($positionOfLastButOneSeparator - 1)
			);
			$parent = $this->getTrimmedString($unTrimmedParent);
		} elseif ($positionOfLastCategorySeparator) {
			$parent = $this->getTrimmedString(substr($fullPath, 0, $positionOfLastCategorySeparator));
		}
		return $parent;
	}

	/**
	 * @param string $line
	 * @return bool
	 */
	private function loadProviderValueImportDataEntityFromLine($line) {
		$positionOfFirstDash = (int)strpos($line, '-');
		$googleId = (int)trim(substr($line, 0, $positionOfFirstDash));
		$fullPath = $this->getTrimmedString(substr($line, $positionOfFirstDash + 1));
		$positionOfLastCategorySeparator = (int)strrpos($fullPath, self::GOOGLE_SEPARATOR);
		$pathBeforeLastSeparator = substr($fullPath, 0, $positionOfLastCategorySeparator);
		$positionOfLastButOneSeparator = (int)strrpos($pathBeforeLastSeparator, self::GOOGLE_SEPARATOR);

		if ($googleId > 0) {
			if ($positionOfLastCategorySeparator > 0) {
				$name = (string)trim(substr($fullPath, $positionOfLastCategorySeparator + 1));
			} else {
				$name = $fullPath;
			}
			$parentFullPath = $this->getParentFullPath(
				$fullPath,
				$positionOfLastButOneSeparator,
				$positionOfLastCategorySeparator
			);
			$feedProviderImportDataEntity = new FeedProviderImportDataEntity();
			$feedProviderImportDataEntity
				->setLanguageId($this->feedProviderLanguageEntity->getLanguageId())
				->setName($name)
				->setFullPath($fullPath)
				->setLastUpdate($this->actualTime)
				->setProviderCatnum($googleId)
				->setIsVisible(true)
				->setFeedProviderId($this->feedProviderLanguageEntity->getFeedProviderId())
				->setParentFullPath($parentFullPath)
				->setIsSetAble(true);
			$hashedName = md5($fullPath);
			$this->cachedEntities[$hashedName] = $feedProviderImportDataEntity;
			return true;
		}
		return false;
	}

	private function loadParentsCatnumsToEntities() {
		foreach ($this->cachedEntities as $item) {
			$parentFullName = $item->getParentFullPath();
			$parentCatnum = '';
			if ($parentFullName !== '') {
				$parentCatnum = $this->cachedEntities[md5($parentFullName)]->getProviderCatnum();
			}
			$item->setProviderParentCatnum($parentCatnum);
		}
	}

	/**
	 * @return bool
	 */
	public function run() {
		$filePointer = fopen($this->fileName, 'r');
		while (($line = fgets($filePointer)) !== false) {
			$this->loadProviderValueImportDataEntityFromLine($line);
		}
		fclose($filePointer);
		$this->loadParentsCatnumsToEntities();
		return (count($this->cachedEntities) > 0);
	}
}
