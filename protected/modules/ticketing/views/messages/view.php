<?php
/* @var $this TicketMessagesController */
/* @var $model TicketMessages */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'لیست TicketMessages', 'url'=>array('index')),
	array('label'=>'افزودن TicketMessages', 'url'=>array('create')),
	array('label'=>'ویرایش TicketMessages', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'حذف TicketMessages', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'مدیریت TicketMessages', 'url'=>array('admin')),
);
?>

<h1>نمایش TicketMessages #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'message_text',
		'seen',
		'reply',
		'ticket_id',
	),
)); ?>
