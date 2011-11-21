<?php

Yii::import( '_featureRequests.models._base.BaseFeatureRequest', true );

/**
 * @property AbstractMessage $message
 * @property int $voteWeightSum
 */
class FeatureRequest extends BaseFeatureRequest
{
  const STATUS_NEW = 'NEW';

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

  public function init()
  {
    if ($this->getIsNewRecord())
    {
      $this->message = new AbstractMessage();
    }
  }

	public function relations() {
		return array_merge( parent::relations(), array(
      'message' => array(self::BELONGS_TO, 'AbstractMessage', 'id'),
      'voteWeightSum' => array(self::STAT, 'Vote', 'feature_request_id', 'select' => 'sum(weight)'),
    ));
	}

	public function save($runValidation=true,$attributes=null)
	{
    $retVal = false;

    if ($this->message->save())
    {
      $this->id = $this->message->id;
      $retVal = parent::save( $runValidation, $attributes );
    }

    return $retVal;
	}

  public function getUrl()
  {
    return array( 'features/show', 'id' => $this->id );
  }
  
  public function getHighestRated()
  {
    $dataProvider = new CActiveDataProvider( 'FeatureRequest', array(
      'criteria' => array(
        //'order' => 't.voteWeightSum DESC',
        'with'  => array( 'message', 'voteWeightSum' ),
      ),
      'pagination' => array(
        'pageSize'=>10,
      ),
    ));
    
    return $dataProvider;
  }
  
}