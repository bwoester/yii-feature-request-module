<?php

Yii::import( '_featureRequests.components.textTruncator.TextTruncator' );

/**
 * Description of FeatureRequest
 *
 * @author Benjamin
 *
 * @property FeatureRequest $model
 */
class FeatureRequestWidget extends CInputWidget
{
  const MODE_SUMMARY = 0;
  const MODE_NORMAL  = 1;

  public $displayMode = self::MODE_NORMAL;
  public $updateUrl = '';

  public function run()
  {
    $this->render('index');
  }

  public function getContent()
  {
    $retVal = $this->model->message->content;

    switch ($this->displayMode)
    {
    case self::MODE_SUMMARY:
        $retVal = TextTruncator::truncate( $retVal, 50, TextTruncator::COUNT_WORDS );
        break;
    case self::MODE_NORMAL:
    default:
        break;
    }

    return $retVal;
  }

  public function getMenu()
  {
    $voteItems = array();
    for ($i = 1; $i <= Vote::$maxWeight; $i++)
    {
      $voteItems[] = array(
        'label'   => $i === 1 ? '1 vote' : "$i votes",
        'method'  => PostMenu::POST,
        'url'     => array(
          'features/vote',
          array( 'featureRequestId' => $this->model->id, 'voteWeight' => $i ),
        ),
      );
    }

    $retVal = $this->widget( 'PostMenu', array(
      'items'=>array(
        array(
          'label' => 'Vote',
          'items' => $voteItems,
        ),
      ),
    ), true );

    return $retVal;
  }

}
