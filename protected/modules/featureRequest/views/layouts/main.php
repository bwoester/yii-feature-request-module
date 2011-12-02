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
    $this->widget( '_featureRequests.widgets.searchOrCreateWidget.SearchOrCreateWidget', array(
      'createUrl' => array('features/create'),
      'searchUrl' => array('features/search'),
      'viewUrl'   => array('features/show'),
      'resultDisplay' => 'message.title',
      'resultId' => 'id',
      'CJuiAutoComplete' => array(
        'source'  => $this->createUrl( 'features/search', array('encode'=>'json') ),
        'name'    => 'term',
        'options' => array(
          'showAnim'=>'fold',
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