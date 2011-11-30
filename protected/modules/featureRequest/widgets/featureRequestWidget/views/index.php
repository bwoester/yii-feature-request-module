<?php
/* @var $this FeatureRequestWidget */
/* @var $user CWebUser */
$user = Yii::app()->user;
?>

<div class="featureRequest">

  <div class="featureRequest-sidebar">

    <div class="featureRequest-votes">
      <span class="counter"><?php echo $this->model->voteWeightSum; ?></span>
      <span class="label">Votes</span>
    </div>

    <div class="featureRequest-actions">
      <?php echo $this->getMenu(); ?>
    </div>

  </div>

  <div class="featureRequest-main-area">

    <h3 class="featureRequest-title"><?php
      echo CHtml::link( $this->model->message->title, $this->model->getUrl() );
    ?></h3>

    <div class="featureRequest-content"><?php echo $this->getContent(); ?></div>

    <div class="featureRequest-info">
      <?php
        // TODO: implement comments, user profiles, ...
  //    $this->widget('zii.widgets.CMenu',array(
  //			'items'=>array(
  //        array('label'=>'by {TODO: link to author profile}' , 'url'=>array('')),
  //        array('label'=>'{TODO: link to show comments}', 'url'=>array('')),
  //      )
  //		));
      ?>
    </div>

    <div class="featureRequest-status-container">
    <?php if ($user->checkAccess(FeatureRequestModule::AUTH_FEATUREREQUEST_CHANGE_STATUS)): ?>
    <?php
      echo CHtml::beginForm( $this->updateUrl );
      echo CHtml::activeHiddenField( $this->model, 'id', array('id'=>false) );

      // since we're generating many forms, we have to ensure we don't generate
      // duplicate html element ids.
      $ddlId = CHtml::activeId( $this->model, 'status' ) . '_' . $this->model->id;
      echo CHtml::activeLabel( $this->model, 'status', array('for'=>$ddlId) );
      echo CHtml::activeDropDownList( $this->model, 'status', $this->model->getStatusListData(), array('id'=>$ddlId) );
      
      echo CHtml::submitButton( "Change" );

      echo CHtml::endForm();
    ?>
    <?php else: ?>
      <span class="label"><?php echo $this->model->getAttributeLabel( 'status' ); ?></span>
      <span class="status"><?php echo $this->model->status; ?></span>
    <?php endif; ?>
    </div>

  </div>

</div>
