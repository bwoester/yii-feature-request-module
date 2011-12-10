<?php

/* @var $cs CClientScript */
$cs = Yii::app()->clientScript;

/* @var $user CWebUser */
$user = Yii::app()->user;

$flashes = $user->getFlashes();

/* @var $this FeatureRequestsBaseController */
$this->beginContent( $this->getModule()->layout );

?>
<div id="featureRequestContainer">

  <?php if (!empty($flashes)): ?>
  <div class="featureRequest-flashes"><?php
    $items = array();
    foreach ($flashes as $key => $flash) {
      $items[] = array( 'label' => $flash );
    }

    $this->widget('zii.widgets.CMenu',array(
      'items' => $items,
    ));

    $cs->registerScript( 'featureRequest-flashes', '
      $(".featureRequest-flashes").animate( {opacity: 1.0}, 5000 ).fadeOut("slow");
    ');

  ?></div>
  <?php endif; ?>

  <div id="searchFeatureRequestContainer"><?php
    $this->widget( '_featureRequests.widgets.LocationBar.LocationBarWidget', array(
      //'model'         => new AbstractMessage(),
      //'attribute'     => 'title',
      'name'          => 'term',
      //'createUrl'     => array('features/create'),
      'searchUrl'     => array('features/search'),
      //'viewUrl'       => array('features/show'),
      //'resultDisplay' => 'message.title',
      //'resultId'      => 'id',
      'options' => array(
        'autocomplete'  => array(
          'source'  => $this->createUrl( 'features/search', array('encode'=>'json') ),
          'name'    => 'term',
          'options' => array(
            'showAnim'  => 'fold',
          ),
        ),
      ),
    ));

    $cs = $this->getClientScript();
    $cs->registerScript('renderFeatureRequestSearchResult', '
      jQuery("#searchFeatureRequestContainer .ui-autocomplete-input")
        .data( "autocomplete" )
        ._renderItem = function( ul, item )
        {
          return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>" + item.message.title + "</a>" )
            .appendTo( ul );
        };
    ');

  ?></div>

  <?php echo $content; ?>

</div>
<?php $this->endContent(); ?>