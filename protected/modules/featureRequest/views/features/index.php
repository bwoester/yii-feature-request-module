<?php

/* @var $this FeaturesController */
/* @var $dataProvider CActiveDataProvider */

$this->widget( 'zii.widgets.CListView', array(
  'dataProvider' => $dataProvider,
  'itemView' => '_featureRequestSummary',
));
