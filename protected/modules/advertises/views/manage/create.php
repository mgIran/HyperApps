<?php
/* @var $this ManageController */
/* @var $model Advertises */

$this->breadcrumbs=array(
	'لیست تبلیغات'=>array('admin'),
	'افزودن تبلیغ',
);

$this->menu=array(
	array('label'=>'لیست تبلیغات', 'url'=>array('admin')),
);
?>

<h1>افزودن تبلیغ</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>