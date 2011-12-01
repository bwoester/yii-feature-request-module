<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class FeatureRequestsBaseController extends CController
{
  
  public function init()
  {
    parent::init();
    $this->layout = '/layouts/main';
  }

  /**
   * @return CClientScript
   */
  public function getClientScript()
  {
    return Yii::app()->clientScript;
  }

  /**
   * @return CAssetManager
   */
  public function getAssetManager()
  {
    return Yii::app()->assetManager;
  }

  protected function checkParams( array $params, $global=null )
  {
    if ($global === null) {
      $global = $_POST;
    }
    
    foreach ( $params as $key => $value )
    {
      if (is_array($value)) {
        $this->checkParams( array($key), $global );
        $this->checkParams( $value, $global[$key] );
      } else {
        if (!isset($global[$value])) {
          throw new CHttpException( 400, 'Your request is invalid.' );
        }
      }
    }
  }

}
