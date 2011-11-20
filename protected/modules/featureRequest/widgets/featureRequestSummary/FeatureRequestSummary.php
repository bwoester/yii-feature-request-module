<?php

/**
 * Description of FeatureRequestSummary
 *
 * @author Benjamin
 *
 * @property FeatureRequest $model
 */
class FeatureRequestSummary extends CInputWidget
{

  public function run()
  {
    $this->render('index');
  }
  
}
