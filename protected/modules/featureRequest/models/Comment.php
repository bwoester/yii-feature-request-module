<?php

Yii::import( '_featureRequests.models._base.BaseComment', true );

class Comment extends BaseComment
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}