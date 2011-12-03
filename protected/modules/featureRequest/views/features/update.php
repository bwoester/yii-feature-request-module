<?php
/* @var $this FeaturesController */
/* @var $featureRequest FeatureRequest */
/* @var $vote Vote */
?>

<h2>Update Feature Request</h2>

<?php echo $this->renderPartial( '_form', array(
  'featureRequest' => $featureRequest,
  'vote' => null,
)); ?>
