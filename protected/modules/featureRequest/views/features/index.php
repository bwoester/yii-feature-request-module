<?php

/* @var $this FeaturesController */
/* @var $dataProvider CActiveDataProvider */

//$models = FeatureRequest::model()->findAll();
//
//foreach ($models as $model)
//{
//  $this->widget( 'featureRequests.widgets.featureRequestSummary.FeatureRequestSummary', array(
//    'model' => $model,
//  ));
//}

$this->widget( 'zii.widgets.CListView', array(
  'dataProvider' => $dataProvider,
  'itemView' => '_featureRequestSummary',
));
