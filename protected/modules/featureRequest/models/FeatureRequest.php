<?php

Yii::import( '_featureRequests.models._base.BaseFeatureRequest', true );

/**
 * @property AbstractMessage $message
 */
class FeatureRequest extends BaseFeatureRequest
{

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

  public function countVoteWeights()
  {
    $retVal = 0;

    /* @var $vote Vote */
    foreach ($this->votes as $vote) {
      $retVal += $vote->weight;
    }

    return $retVal;
  }
  
}