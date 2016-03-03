<?php
/* @var $this BaseManageController */
/* @var $model Apps */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت', 'url'=>Yii::app()->createUrl('/manageApps/'.$this->controller.'/admin')),
);
?>

<h1>افزودن برنامه جدید</h1>
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#general">عمومی</a></li>
        <li class="disabled"><a >تصاویر</a></li>
    </ul>

    <div class="tab-content">
<div id="general" class="tab-pane fade in active">
<?php $this->renderPartial('manageApps.views.baseManage._form', array('model'=>$model,'icon'=>$icon,'app' => $app )); ?>
    </div>
        </div>