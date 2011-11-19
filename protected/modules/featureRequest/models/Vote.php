<?php

Yii::import( '_featureRequests.models._base.BaseVote', true );

class Vote extends BaseVote
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}