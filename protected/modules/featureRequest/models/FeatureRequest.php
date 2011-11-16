<?php

Yii::import('application.models._base.BaseFeatureRequest');

class FeatureRequest extends BaseFeatureRequest
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}