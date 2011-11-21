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
    echo $form->errorSummary($vote);
  ?>

  <div class="row">
    <?php echo $form->labelEx($featureRequest->message,'title'); ?>
    <?php echo $form->textField($featureRequest->message,'title',array('size'=>45,'maxlength'=>45)); ?>
    <?php echo $form->error($featureRequest->message,'title'); ?>
  </div>

  <div class="row">
    <?php echo $form->labelEx($vote,'weight'); ?>
    <?php echo $form->dropDownList($vote, 'weight', $vote->listData()); ?>
    <?php echo $form->error($vote,'weight'); ?>
  </div>

  <div class="row">
    <?php echo $form->labelEx($featureRequest->message,'content'); ?>
    <?php echo $form->textArea($featureRequest->message,'content',array('rows'=>6, 'cols'=>50)); ?>
    <?php echo $form->error($featureRequest->message,'content'); ?>
  </div>

  <div class="row buttons">
    <?php echo CHtml::submitButton( $featureRequest->isNewRecord ? 'Create' : 'Save' ); ?>
  </div>

<?php $this->endWidget(); ?>

</div><!-- form -->