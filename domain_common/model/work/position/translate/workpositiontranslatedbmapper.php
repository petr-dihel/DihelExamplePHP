<?php 
/**
 * @package ExampleDIhelPHP
* @subpackage Core
 */ 
class WorkPositionTranslateDbMapper extends BaseCommonDbMapper { 
 
	/** @return WorkPositionTranslateEntity */
	protected function createEntity() {
		return new WorkPositionTranslateEntity();
	}

	/** @return string */
	protected function getTableName() {
		return "work_position_translate";
	}

 }