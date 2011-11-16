<?php

Yii::import('application.models._base.BaseVote');

class Vote extends BaseVote
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}