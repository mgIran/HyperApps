<?php
/* @var $this TicketsManageController */
/* @var $model Tickets */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت', 'url'=>array('admin')),
);
?>

<h1>افزودن Tickets</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>