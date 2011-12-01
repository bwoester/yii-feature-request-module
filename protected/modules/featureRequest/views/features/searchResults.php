<?php

/* @var $this FeaturesController */
/* @var $dataProvider CActiveDataProvider */

?>

<p class="info">
  Can't find what you're looking for?
  <?php echo CHtml::link( 'Submit a new feature request', array('create') ); ?>!
</p>

<?php

$this->widget( 'zii.widgets.CListView', array(
  'dataProvider' => $dataProvider,
  'itemView' => '_featureRequestSummary',
));
