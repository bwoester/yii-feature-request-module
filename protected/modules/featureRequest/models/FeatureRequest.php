<?php

Yii::import( '_featureRequests.models._base.BaseFeatureRequest', true );

/**
 * @property AbstractMessage $message
 * @property int $voteWeightSum
 * @property Vote $userVote
 */
class FeatureRequest extends BaseFeatureRequest
{
  const STATUS_NEW = 'NEW';
  
  /**
   * @param string $className
   * @return FeatureRequest
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

  public function getUserVote()
  {
    if ($this->getIsNewRecord()) {
      throw new CException( "Can't get user vote of feature request that isn't yet saved!" );
    }

    $vote = Vote::model()->fromUser()->find( 'feature_request_id = :id', array(
      ':id' => $this->id,
    ));

    if (!$vote instanceof Vote)
    {
      $vote = new Vote();
      $vote->abstract_user_id = $this->getAbstractUser()->id;
      $vote->feature_request_id = $this->id;
    }

    return $vote;
  }
  
}