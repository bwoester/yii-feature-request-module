<?php

Yii::import( '_featureRequests.models._base.BaseVote', true );

/**
 * LazyLoadAbstractUserBehavior:
 * @method AbstractUser getAbstractUser
 *
 * ConfigurableBehavior:
 * @method mixed getConfigValue
 * @method void setModuleInstance
 */
class Vote extends BaseVote
{
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
      'lazyLoadAbstractUser'  => 'LazyLoadAbstractUserBehavior',
      'configurable'          => array(
        'class'       => 'ConfigurableBehavior',
        'moduleClass' => 'FeatureRequestModule',
      ),
    ));
  }

	public function rules()
  {
		return array_merge( parent::rules(), array(
			array('weight', 'numerical', 'integerOnly'=>true, 'min'=>1, 'max'=>$this->getMaxWeight() ),
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

  private function getMaxWeight()
  {
    return $this->getConfigValue( FeatureRequestModule::CFG_MAX_VOTE_WEIGHT );
  }

  public function listData()
  {
    $retVal = array();

    for ($i = 1; $i <= $this->getMaxWeight(); $i++) {
      $retVal[$i] = $i;
    }

    return $retVal;
  }
  
}