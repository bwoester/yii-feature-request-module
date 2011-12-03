<?php
/* @var $this FeaturesController */
/* @var $featureRequest FeatureRequest */
/* @var $vote Vote */
?>

<div class="form">

<?php
$form = $this->beginWidget('CActiveForm', array(
  'id'                    => 'feature-request-form',
  'enableAjaxValidation'  => false,
));
/* @var $form CActiveForm */
?>

  <p class="note">Fields with <span class="required">*</span> are required.</p>

  <?php
    echo $form->errorSummary($featureRequest);
    echo $form->errorSummary($featureRequest->message);
    
    if ($vote instanceof Vote) {
      echo $form->errorSummary($vote);
    }
    
    if (!$featureRequest->getIsNewRecord()) {
      echo $form->hiddenField($featureRequest,'id');
    }
  ?>

  <div class="row">
    <?php echo $form->labelEx($featureRequest->message,'title'); ?>
    <?php echo $form->textField($featureRequest->message,'title',array('size'=>45,'maxlength'=>45)); ?>
    <?php echo $form->error($featureRequest->message,'title'); ?>
  </div>

  <?php if ($vote instanceof Vote): ?>
  <div class="row">
    <?php echo $form->labelEx($vote,'weight'); ?>
    <?php echo $form->dropDownList($vote, 'weight', $vote->listData()); ?>
    <?php echo $form->error($vote,'weight'); ?>
  </div>
  <?php endif; ?>

  <div class="row">
    <?php echo $form->labelEx($featureRequest->message,'content'); ?>
    <?php
    $this->widget('_featureRequests.widgets.wymEditorWidget.EWYMeditor',array(
      'model'     => $featureRequest->message,
      'attribute' => 'content',
    ));
    ?>
    <?php echo $form->error($featureRequest->message,'content'); ?>
  </div>

  <div class="row buttons">
    <?php echo CHtml::submitButton( $featureRequest->isNewRecord ? 'Create' : 'Save', array('id'=>'submitFeatureRequestForm') ); ?>
  </div>

<?php $this->endWidget(); ?>

</div><!-- form -->