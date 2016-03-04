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
        <li <?= $step == 1 ?'class="active"':''; ?> >
            <a data-toggle="tab" href="#platform">پلتفرم</a>
        </li>
        <li <?= $step == 2 ?'class="active"':'class="disabled"'; ?> >
            <a <?= $step == 2?'data-toggle="tab" href="#info"':''; ?> >اطلاعات برنامه</a>
        </li>
        <li class="disabled">
            <a href="#">تصاویر برنامه</a>
        </li>
    </ul>

    <div class="tab-content">

        <div id="platform" class="tab-pane fade <?= $step == 1?'in active':''; ?>">
            <?php $this->renderPartial('_platform', array('model'=>$model)); ?>
        </div>
        <?
        if($model->platform_id):
            ?>
        <div id="info" class="tab-pane fade <?= $step == 2?'in active':''; ?>">
            <?php $this->renderPartial('_form', array(
                'model'=>$model,
                'icon' => $icon,
                'app' => $app
            )); ?>
        </div>
        <?
        endif;
        ?>
    </div>
</div>