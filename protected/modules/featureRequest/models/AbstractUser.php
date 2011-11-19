<?php

Yii::import( '_featureRequests.models._base.BaseAbstractUser', true );

class AbstractUser extends BaseAbstractUser
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}