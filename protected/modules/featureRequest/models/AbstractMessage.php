<?php

Yii::import( '_featureRequests.models._base.BaseAbstractMessage', true );

class AbstractMessage extends BaseAbstractMessage
{

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

  public function init()
  {
    if ($this->getIsNewRecord())
    {
      $dateTime = new DateTime( null, new DateTimeZone('UTC') );
      $this->created_time = $dateTime->format( 'c' );
    }
  }

}