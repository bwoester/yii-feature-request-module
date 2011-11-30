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

	public function rules() {
		return array_merge( parent::rules(), array(
		));
	}

  protected function beforeSave()
  {
    $this->title = CHtml::encode( $this->title );
    return parent::beforeSave();
  }
}