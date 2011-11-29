<?php

Yii::import( 'featureRequests.widgets.featureRequestWidget.FeatureRequestWidget', true );

$this->widget( 'featureRequests.widgets.featureRequestWidget.FeatureRequestWidget', array(
  'model'       => $data,
  'displayMode' => FeatureRequestWidget::MODE_SUMMARY,
));
