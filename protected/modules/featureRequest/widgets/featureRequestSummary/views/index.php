<div class="featureRequest-summary">
  
  <div class="featureRequest-votes">
    <span class="counter">42</span>
    <span class="label">Votes</span>
  </div>
  
	<div class="featureRequest-actions">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Vote', 'items'=>array(
          array('label'=>'1 vote' , 'url'=>array('')),
          array('label'=>'2 votes', 'url'=>array('')),
          array('label'=>'3 votes', 'url'=>array('')),
        )),
      )
		)); ?>
	</div><!-- featureRequestActions -->  
  
	<div class="featureRequest-content">
    Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy
    eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam
    voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet
    clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit
    amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam
    nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed
    diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.
    Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor
    sit amet.    
  </div>

	<div class="featureRequest-info">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
        array('label'=>'by {TODO: link to author profile}' , 'url'=>array('')),
        array('label'=>'{TODO: link to show comments}', 'url'=>array('')),
      )
		)); ?>
	</div><!-- featureRequestActions -->  
  
  
</div>
