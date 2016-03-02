<?php
/* @var $this BaseManageController */
/* @var $model Apps */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->title=>array('view','id'=>$model->id),
	'ویرایش',
);

$this->menu=array(
	array('label'=>'افزودن', 'url'=>Yii::app()->createUrl('/manageApps/'.$this->controller.'/create')),
    array('label'=>'مدیریت', 'url'=>Yii::app()->createUrl('/manageApps/'.$this->controller.'/admin')),
);
?>

<h1>ویرایش Apps <?php echo $model->id; ?></h1>
    <ul class="nav nav-tabs">
        <li class="<?= ($step == 1?'active':''); ?>"><a data-toggle="tab" href="#general">عمومی</a></li>
        <li class="<?= $model->getIsNewRecord()?'disabled':''; ?> <?= ($step == 2?'active':''); ?>"><a data-toggle="tab" href="#attributes">تصاویر</a></li>
    </ul>

    <div class="tab-content">
    <div id="general" class="tab-pane fade <?= ($step == 1?'in active':''); ?>">
        <?php $this->renderPartial('manageApps.views.baseManage._form', array('model'=>$model,'image'=>$image)); ?>
    </div>
<?
if(!$model->getIsNewRecord()){
    ?>
    <div id="general" class="tab-pane fade <?= ($step == 2?'in active':''); ?>">
        <?php $this->renderPartial('manageApps.views.baseManage._imagesUpload', array('model'=>$model)); ?>
    </div>
<?
}
?>
    </div>