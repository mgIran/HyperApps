<?php
/* @var $this TicketsManageController */
/* @var $model Tickets */

$this->breadcrumbs=array(
	'مدیریت',
);

$this->menu=array(
	array('label'=>'افزودن Tickets', 'url'=>array('create')),
);
?>

<h1>مدیریت Tickets</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tickets-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'subject',
		'sender',
		'status',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
