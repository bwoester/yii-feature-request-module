<?php

class FeaturesController extends FeatureRequestsBaseController
{
	public function actionIndex()
	{
		$this->render('index');
	}
  
  public function actionSearch()
  {
    $result = array(
      'Improve User Interface',
      'Add User Profiles',
    );
    
    echo CJSON::encode( $result );
  }
}