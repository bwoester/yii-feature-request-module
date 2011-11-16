<?php

Yii::import('application.models._base.BaseAbstractMessage');

class AbstractMessage extends BaseAbstractMessage
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}