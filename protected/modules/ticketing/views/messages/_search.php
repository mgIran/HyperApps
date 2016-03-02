<?php
/* @var $this TicketMessagesController */
/* @var $model TicketMessages */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'message_text'); ?>
		<?php echo $form->textField($model,'message_text',array('size'=>60,'maxlength'=>2000)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'seen'); ?>
		<?php echo $form->textField($model,'seen'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reply'); ?>
		<?php echo $form->textField($model,'reply'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ticket_id'); ?>
		<?php echo $form->textField($model,'ticket_id',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->