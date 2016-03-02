<?php
/* @var $this TicketMessagesController */
/* @var $model TicketMessages */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت', 'url'=>array('admin')),
);
?>

<h1>افزودن TicketMessages</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>