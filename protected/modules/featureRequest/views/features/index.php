<?php
$this->breadcrumbs = array( 'Feature requests' );

for ($i=0; $i<5; $i++)
{
  $this->widget( 'featureRequests.widgets.featureRequestSummary.FeatureRequestSummary', array(
  ));
}