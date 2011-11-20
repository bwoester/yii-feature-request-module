<?php

Yii::import( '_featureRequests.models._base.BaseVote', true );

class Vote extends BaseVote
{
  protected $maxWeight = 3;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function rules()
  {
		return array_merge( parent::rules(), array(
			array('abstract_user_id', 'numerical', 'integerOnly'=>true, 'min'=>1, 'max'=>$this->maxWeight ),
		));
	}

  public function listData()
  {
    $retVal = array();

    for ($i = 1; $i <= $this->maxWeight; $i++) {
      $retVal[$i] = $i;
    }

    return $retVal;
  }
  
}