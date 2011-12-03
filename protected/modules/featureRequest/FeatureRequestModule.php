<?php

class FeatureRequestModule extends CWebModule
{
  // const COMP_TEXT_TRUNCATOR = 'textTruncator';

  const AUTH_OP_FEATUREREQUEST_CREATE        = 'FeatureRequest.create';
  const AUTH_OP_FEATUREREQUEST_UPDATE        = 'FeatureRequest.update';
  const AUTH_OP_FEATUREREQUEST_VOTE          = 'FeatureRequest.vote';

  public $maxVoteWeight = 3;

  /**
   * Constructor.
   * @param string $id the ID of this module
   * @param CModule $parent the parent module (if any)
   * @param mixed $config the module configuration. It can be either an array or
   * the path of a PHP file returning the configuration array.
   */
  public function __construct($id,$parent,$config=null)
  {
    $this->defaultController = 'features';
    $this->setComponents( $this->getDefaultComponentsConfiguration() );
    parent::__construct( $id, $parent, $config );
  }

	public function init()
	{
		$this->setAliases(array(
			'_featureRequests' => dirname(__FILE__),
		));

		// import the module-level models and components
		$this->setImport(array(
			'_featureRequests.behaviors.*',
			'_featureRequests.components.*',
			'_featureRequests.models.*',
		));
    
    /* @var $am CAssetManager */
    $am = Yii::app()->assetManager;
    /* @var $cs CClientScript */
    $cs = Yii::app()->clientScript;

    $cs->registerCssFile(
      $am->publish( dirname(__FILE__) . '/assets/css/main.css' )
    );

    Vote::$maxWeight = $this->maxVoteWeight;
	}

  /**
   * Returns a list of authItems defined and used by this module.
   * @param int $type - you can filter by auth item type by passing
   *        CAuthItem::TYPE_OPERATION, CAuthItem::TYPE_ROLE or
   *        CAuthItem::TYPE_TASK. For everything else, you'll get all
   *        authItems.
   * @return array - indexed by const name, values are the auth item names.
   */
  public static function getAuthItems( $type=null )
  {
    $reflect = new ReflectionClass(__CLASS__);
    $aConstants = $reflect->getConstants();
    $prefix = '';

    switch ($type)
    {
    case CAuthItem::TYPE_OPERATION:
        $prefix = 'AUTH_OP_';
        break;
    case CAuthItem::TYPE_ROLE:
        $prefix = 'AUTH_RO_';
        break;
    case CAuthItem::TYPE_TASK:
        $prefix = 'AUTH_TA_';
        break;
    }

    $retVal = array();

    if ($prefix === '')
    {
      foreach ($aConstants as $constName => $constValue)
      {
        if (strpos($constName,'AUTH_OP_') === 0 || strpos($constName,'AUTH_RO_') === 0 || strpos($constName,'AUTH_TA_') === 0) {
          $retVal[$constName] = $constValue;
        }
      }
    }
    else
    {
      foreach ($aConstants as $constName => $constValue)
      {
        if (strpos($constName,$prefix) === 0) {
          $retVal[$constName] = $constValue;
        }
      }
    }

    return $retVal;
  }

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}

  private function getDefaultComponentsConfiguration()
  {
    return array(
//      self::COMP_TEXT_TRUNCATOR => array(
//        'class' => '_featureRequests.components.textTruncator.TextTruncator',
//      ),
    );
  }
}
