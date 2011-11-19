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

}
