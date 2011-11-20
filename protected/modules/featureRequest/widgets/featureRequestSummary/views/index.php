<?php
/* @var $this FeatureRequestSummary */
?>

<div class="featureRequest-summary">
  
  <div class="featureRequest-votes">
    <span class="counter"><?php echo $this->model->countVoteWeights(); ?></span>
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
				array('label'=>'Admin', 'items'=>array(
          array('label'=>'Accept' , 'url'=>array('')),
          array('label'=>'Reject', 'url'=>array('')),
        )),
      )
		)); ?>
	</div><!-- featureRequestActions -->  

  <h3 class="featureRequest-title"><?php
    echo CHtml::link( $this->model->message->title, $this->model->getUrl() );
  ?></h3>

	<div class="featureRequest-content"><?php
    $this->beginWidget( 'CMarkdown', array('purifyOutput'=>true) );
    echo $this->model->message->content;
    $this->endWidget();
  ?></div>

	<div class="featureRequest-info">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
        array('label'=>'by {TODO: link to author profile}' , 'url'=>array('')),
        array('label'=>'{TODO: link to show comments}', 'url'=>array('')),
      )
		)); ?>
	</div><!-- featureRequestActions -->  
  
  
</div>
