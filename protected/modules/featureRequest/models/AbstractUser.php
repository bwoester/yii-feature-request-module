<?php

Yii::import('application.models._base.BaseAbstractUser');

class AbstractUser extends BaseAbstractUser
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}