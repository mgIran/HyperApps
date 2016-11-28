<?php
/* @var $this ManageController */
/* @var $model Advertises */
/* @var $cover array */

$this->breadcrumbs=array(
	'لیست تبلیغات'=>array('admin'),
	'ویرایش',
);

$this->menu=array(
	array('label'=>'لیست تبلیغات', 'url'=>array('admin')),
	array('label'=>'افزودن تبلیغ', 'url'=>array('create')),
	array('label'=>'افزودن تبلیغ ویژه', 'url'=>array('createSpecial')),
);
?>

<h1>ویرایش تبلیغ <?php echo $model->app->title ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'cover' => $cover)); ?>