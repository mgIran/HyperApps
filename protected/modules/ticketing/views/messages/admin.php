<?php
/* @var $this TicketMessagesController */
/* @var $model TicketMessages */

$this->breadcrumbs=array(
	'مدیریت',
);

$this->menu=array(
	array('label'=>'افزودن TicketMessages', 'url'=>array('create')),
);
?>

<h1>مدیریت Ticket Messages</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ticket-messages-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'message_text',
		'seen',
		'reply',
		'ticket_id',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
