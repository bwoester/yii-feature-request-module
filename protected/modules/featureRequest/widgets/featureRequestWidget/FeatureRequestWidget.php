<?php

Yii::import( '_featureRequests.components.textTruncator.TextTruncator' );

/**
 * Description of FeatureRequest
 *
 * @author Benjamin
 *
 * @property FeatureRequest $model
 *
 * ConfigurableBehavior:
 * @method mixed getConfigValue
 * @method void setModuleInstance
 */
class FeatureRequestWidget extends CInputWidget
{
  const MODE_SUMMARY = 0;
  const MODE_NORMAL  = 1;

  public $displayMode = self::MODE_NORMAL;
  public $updateUrl = '';

  public function behaviors()
  {
		return array(
      'configurable'  => array(
        'class'       => 'ConfigurableBehavior',
        'moduleClass' => 'FeatureRequestModule',
      ),
    );
  }

  public function init()
  {
    parent::init();
    $this->attachBehaviors( $this->behaviors() );
  }

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
    $items = array(
      $this->getVoteMenu(),
      $this->getAdminMenu(),
    );
    
    $items = array_filter( $items, array('MenuFilterHelper','removeEmpty') );

    return $this->widget( 'PostMenu', array(
      'items' => $items,
    ), true );
  }
  
  private function getVoteMenu()
  {
    $items = array();
    for ($i = 1; $i <= $this->getMaxVoteWeight(); $i++)
    {
      $items[] = array(
        'label'   => $i === 1 ? '1 vote' : "$i votes",
        'method'  => PostMenu::POST,
        'url'     => array(
          'features/vote',
          array( 'featureRequestId' => $this->model->id, 'voteWeight' => $i ),
        ),
      );
    }
  
    return array(
      'label' => 'Vote',
      'items' => $items,
    );
  }

  
  private function getAdminMenu()
  {
    /* @var $user CWebUser */
    $user = Yii::app()->user;
    $items = array();

    if ($user->checkAccess(FeatureRequestModule::AUTH_OP_FEATUREREQUEST_UPDATE))
    {
      $items[] = array(
        'label'   => 'Update',
        'method'  => PostMenu::POST,
        'url'     => array(
          'features/update',
          array( 'featureRequestId' => $this->model->id ),
        ),
      );      
    }
  
    return array(
      'label' => 'Admin',
      'items' => $items,
    );
  }

  private function getMaxVoteWeight()
  {
    return $this->getConfigValue( FeatureRequestModule::CFG_MAX_VOTE_WEIGHT );
  }
  
}

class MenuFilterHelper
{
  static public function removeEmpty( $item ) {
    return is_array( $item ) && isset( $item['items'] ) && !empty( $item['items'] );
  }
}
