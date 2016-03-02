<?php
/* @var $this TicketMessagesController */
/* @var $data TicketMessages */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('message_text')); ?>:</b>
	<?php echo CHtml::encode($data->message_text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('seen')); ?>:</b>
	<?php echo CHtml::encode($data->seen); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reply')); ?>:</b>
	<?php echo CHtml::encode($data->reply); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ticket_id')); ?>:</b>
	<?php echo CHtml::encode($data->ticket_id); ?>
	<br />


</div>