<?php

/**
 * @package ExampleDIhelPHP
 * @subpackage Core
 */
class WorkPositionEntity extends BaseEntity {

	use TId;

	/** @var int */
	private $isAvailable;

	/** @var int */
	private $datetimeRemoved;

	/**
	 * @return int
	 */
	public function getIsAvailable() {
		return $this->isAvailable;
	}

	/**
	 * @param int $isAvailable
	 * @return $this
	 */
	public function setIsAvailable($isAvailable) {
		$this->isAvailable = (int)$isAvailable;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getDatetimeRemoved() {
		return $this->datetimeRemoved;
	}

	/**
	 * @param int $datetimeRemoved
	 * @return WorkPositionEntity
	 */
	public function setDatetimeRemoved($datetimeRemoved) {
		$this->datetimeRemoved = $datetimeRemoved;
		return $this;
	}

	/**
	 * @param int $languageId
	 * @return WorkPositionTranslateEntity
	 */
	public function getWorkPositionTranslateByLanguageId($languageId) {
		return ServiceFactory::getInstance()->getServiceByName(WorkPositionTranslateService::getName())
			->getWorkPositionTranslateByWorkPositionIdAndLanguageId($this->getId(), $languageId);
	}

	/**
	 * @return WorkPositionTranslateEntity[]
	 */	
	public function findWorkPositionTranslates() {
		return ServiceFactory::getInstance()->getServiceByName(WorkPositionTranslateService::getName())
			->getWorkPositionTranslateByWorkPositionId($this->getId());
	}
}
