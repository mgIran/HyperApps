<?php
/* @var $this ManageController */
/* @var $model SpecialAdvertises */
/* @var $cover array */

$this->breadcrumbs=array(
	'لیست تبلیغات'=>array('admin'),
	'افزودن تبلیغات',
);

$this->menu=array(
	array('label'=>'لیست تبلیغات', 'url'=>array('admin')),
);
?>

<h1>افزودن تبلیغ ویژه</h1>

<?php $this->renderPartial('_form_special', array('model'=>$model,'cover' => $cover)); ?>