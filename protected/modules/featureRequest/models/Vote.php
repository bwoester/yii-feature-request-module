<?php

Yii::import( '_featureRequests.models._base.BaseVote', true );

class Vote extends BaseVote
{
  protected $maxWeight = 3;

  /**
   * @param string $className
   * @return Vote
   */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

  public function behaviors()
  {
		return array_merge( parent::behaviors(), array(
      'lazyLoadAbstractUser' => 'LazyLoadAbstractUserBehavior',
    ));
  }

	public function rules()
  {
		return array_merge( parent::rules(), array(
			array('weight', 'numerical', 'integerOnly'=>true, 'min'=>1, 'max'=>$this->maxWeight ),
		));
	}

  /**
   * Cares about deleting the record if its weight is set to zero.
   * @see CActiveRecord::save
   */
  public function save($runValidation=true,$attributes=null)
  {
    if (!$this->getIsNewRecord() && intval($this->weight) === 0) {
      return $this->delete();
    } else {
      return parent::save($runValidation,$attributes);
    }
  }

  public function fromUser( $abstractUser=null )
  {
    if (!$abstractUser instanceof AbstractUser) {
      $abstractUser = $this->getAbstractUser();
    }

    $this->getDbCriteria()->mergeWith(array(
      'with'      => 'abstractUser',
      'together'  => true,
      'condition' => 'abstractUser.app_user_id = :appUserId',
      'params'    => array( ':appUserId' => $abstractUser->app_user_id ),
    ));

    return $this;
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