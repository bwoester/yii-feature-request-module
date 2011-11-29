<?php

class FeatureRequestModule extends CWebModule
{
  const COMP_TEXT_TRUNCATOR = 'textTruncator';

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
