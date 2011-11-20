<?php

/* @var $this FeatureRequestsBaseController */
$this->beginContent( $this->getModule()->layout );

?>
<div id="featureRequestContainer">

  <div id="searchFeatureRequestContainer"><?php
    echo CHtml::form( array('features/create') );

    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
      'name'    => 'featureRequestTitle',
      'source'  => $this->createUrl('features/search'),
      'options' => array(
        'showAnim'=>'fold',
      ),
    ));

    echo CHtml::submitButton('create');
    
    echo CHtml::endForm();
  ?></div>

  <?php echo $content; ?>

</div>
<?php $this->endContent(); ?>