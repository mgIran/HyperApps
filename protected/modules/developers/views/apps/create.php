<?php
/* @var $this AppsController */
/* @var $model Apps */
?>

<div class="container">
    <h3>افزودن برنامه جدید</h3>

    <?php if(Yii::app()->user->hasFlash('success')):?>
        <div class="alert alert-success fade in">
            <button class="close close-sm" type="button" data-dismiss="alert"><i class="icon-remove"></i></button>
            <?php echo Yii::app()->user->getFlash('success');?>
        </div>
    <?php elseif(Yii::app()->user->hasFlash('fail')):?>
        <div class="alert alert-danger fade in">
            <button class="close close-sm" type="button" data-dismiss="alert"><i class="icon-remove"></i></button>
            <?php echo Yii::app()->user->getFlash('fail');?>
        </div>
    <?php endif;?>

    <ul class="nav nav-tabs">
        <li class="active">
            <a data-toggle="tab" href="#info">اطلاعات برنامه</a>
        </li>
        <li>
            <a data-toggle="" href="#">تصاویر برنامه</a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="info" class="tab-pane fade in active">
            <?php $this->renderPartial('_form', array('model'=>$model)); ?>
        </div>
    </div>
</div>