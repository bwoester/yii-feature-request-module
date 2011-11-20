<?php

$models = FeatureRequest::model()->findAll();

foreach ($models as $model)
{
  $this->widget( 'featureRequests.widgets.featureRequestSummary.FeatureRequestSummary', array(
    'model' => $model,
  ));
}