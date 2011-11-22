<?php

Yii::import( '_featureRequests.models._base.BaseFeatureRequest', true );

/**
 * @property AbstractMessage $message
 * @property int $voteWeightSum
 */
class FeatureRequest extends BaseFeatureRequest
{
  const STATUS_NEW = 'NEW';
  
  // Only available for withVoteWeightSum():
  //public $voteWeightSum = 0;

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
  
  // Named scope that populates $voteWeightSum vars
  public function withVoteWeightSum( $orderby=null )
  {
    $criteria = $this->getDbCriteria();
    $criteria->select = array( '*', 'SUM(v.weight) AS voteWeightSum' );
    $criteria->join = 'LEFT JOIN vote AS v ON (t.id = v.feature_request_id)';
    
    if ($orderby!==null) {
      $criteria->order = $orderby;
    }
    
    return $this;
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
    $dataProvider = new CActiveDataProvider( get_class($this), array(
      'criteria'  => array(
        'select'  => 't.*, sum(votes.weight) as voteWeightSum',
        'with'    => array( 'message', 'votes' ),
        'together'=> true,
        'order'   => 'voteWeightSum DESC',
        'group'   => 't.id',
      ),
      'pagination' => array(
        'pageSize' => 10,
      ),
    ));
    
    return $dataProvider;
  }
  
}