<?php
/* @var $this TicketMessagesController */
/* @var $model TicketMessages */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ticket-messages-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">فیلد های دارای <span class="required">*</span> الزامی هستند.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'message_text'); ?>
		<?php echo $form->textField($model,'message_text',array('size'=>60,'maxlength'=>2000)); ?>
		<?php echo $form->error($model,'message_text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'seen'); ?>
		<?php echo $form->textField($model,'seen'); ?>
		<?php echo $form->error($model,'seen'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reply'); ?>
		<?php echo $form->textField($model,'reply'); ?>
		<?php echo $form->error($model,'reply'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ticket_id'); ?>
		<?php echo $form->textField($model,'ticket_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'ticket_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->