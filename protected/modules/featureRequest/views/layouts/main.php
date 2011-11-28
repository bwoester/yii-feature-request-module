<?php

/* @var $this FeatureRequestsBaseController */
$this->beginContent( $this->getModule()->layout );

?>
<div id="featureRequestContainer">

  <div class="featureRequest-flashes"><?php

    /* @var $user CWebUser */
    $user = Yii::app()->user;
    /* @var $cs CClientScript */
    $cs   = Yii::app()->clientScript;
    
    $items = array();
    foreach ($user->getFlashes() as $key => $flash) {
      $items[] = array( 'label' => $flash );
    }

    $this->widget('zii.widgets.CMenu',array(
      'items' => $items,
    ));

    $cs->registerScript( 'featureRequest-flashes', '
      $(".featureRequest-flashes").animate( {opacity: 1.0}, 5000 ).fadeOut("slow");
    ');

  ?></div>

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