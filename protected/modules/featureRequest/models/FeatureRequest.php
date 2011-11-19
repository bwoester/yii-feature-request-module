<?php

Yii::import( '_featureRequests.models._base.BaseFeatureRequest', true );

class FeatureRequest extends BaseFeatureRequest
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}