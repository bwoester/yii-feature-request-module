<?php $this->beginContent('//layouts/column1'); ?>

  <div id="searchFeatureRequestContainer">
  <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
    'name'    => 'searchFeatureRequest',
    'source'  => $this->createUrl('features/search'),
    'options' => array(
      'showAnim'=>'fold',
    ),
  )); ?>
  </div>

  <?php echo $content; ?>

<?php $this->endContent(); ?>