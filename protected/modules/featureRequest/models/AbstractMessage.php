<?php

Yii::import( '_featureRequests.models._base.BaseAbstractMessage', true );

class AbstractMessage extends BaseAbstractMessage
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}