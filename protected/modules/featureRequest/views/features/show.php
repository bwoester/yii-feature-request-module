<?php
/* @var $this FeaturesController */
/* @var $featureRequest FeatureRequest */
/* @var $vote Vote */



$this->widget( 'featureRequests.widgets.featureRequestWidget.FeatureRequestWidget', array(
  'model' => $featureRequest,
));
