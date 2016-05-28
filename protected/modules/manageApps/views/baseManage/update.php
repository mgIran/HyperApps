<?php
/* @var $this BaseManageController */
/* @var $model Apps */
/* @var $icon array */
/* @var $packageDataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->title=>array('view','id'=>$model->id),
	'ویرایش',
);

$this->menu=array(
	array('label'=>'افزودن', 'url'=>Yii::app()->createUrl('/manageApps/'.$this->controller.'/create')),
    array('label'=>'مدیریت', 'url'=>Yii::app()->createUrl('/manageApps/'.$this->controller.'/admin')),
);
if(isset($_GET['step']))
    $step = (int)$_GET['step'];
?>

<h1>ویرایش برنامه <?php echo $model->id; ?></h1>
    <ul class="nav nav-tabs">
        <li class="<?= ($step == 1?'active':''); ?>"><a data-toggle="tab" href="#general">عمومی</a></li>
        <li class="<?= $model->getIsNewRecord()?'disabled':''; ?> <?= ($step == 2?'active':''); ?>"><a data-toggle="tab" href="#packages">بسته ها</a></li>
        <li class="<?= $model->getIsNewRecord()?'disabled':''; ?> <?= ($step == 3?'active':''); ?>"><a data-toggle="tab" href="#pics">تصاویر</a></li>
    </ul>

    <div class="tab-content">
    <div id="general" class="tab-pane fade <?= ($step == 1?'in active':''); ?>">
        <?php $this->renderPartial('manageApps.views.baseManage._form', array('model'=>$model,'icon'=>$icon)); ?>
    </div>
        <? if(!$model->getIsNewRecord()):?>
            <div id="packages" class="tab-pane fade <?= ($step == 2?'in active':''); ?>">
                <?php $this->renderPartial('manageApps.views.baseManage._package', array('model'=>$model, 'dataProvider'=>$packageDataProvider)); ?>
            </div>
        <? endif;?>
        <? if(!$model->getIsNewRecord()):?>
            <div id="pics" class="tab-pane fade <?= ($step == 3?'in active':''); ?>">
                <?php $this->renderPartial('manageApps.views.baseManage._imagesUpload', array('model'=>$model ,'images' => $images)); ?>
            </div>
        <? endif;?>
    </div>