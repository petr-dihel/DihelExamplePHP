<?php 
/**
 * @package ExampleDIhelPHP
* @subpackage Core
 */ 
class WorkPositionTranslateEntity extends BaseEntity {

	use TLanguageId;
	use TName;

	/**
	 * @var int
	 */
	private $workPositionId;

	/**
	 * @return int
	 */
	public function getWorkPositionId() {
		return $this->workPositionId;
	}

	/**
	 * @param int $workPositionId
	 * @return WorkPositionTranslateEntity
	 */
	public function setWorkPositionId($workPositionId) {
		$this->workPositionId = $workPositionId;
		return $this;
	}

}