<?php
/* @var $this TicketsManageController */
/* @var $model Tickets */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'لیست Tickets', 'url'=>array('index')),
	array('label'=>'افزودن Tickets', 'url'=>array('create')),
	array('label'=>'ویرایش Tickets', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'حذف Tickets', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'مدیریت Tickets', 'url'=>array('admin')),
);
?>

<h1>نمایش Tickets #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'subject',
		'sender',
		'status',
	),
)); ?>
