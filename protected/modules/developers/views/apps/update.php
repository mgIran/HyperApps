<?php
/* @var $this AppsController */
/* @var $model Apps */

if(isset($_GET['step']) && !empty($_GET['step']))
    $step = (int)$_GET['step'];
?>

<div class="container">
    <h3>ویرایش برنامه <?= $model->title; ?></h3>

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
        <li class="disabled" >
            <a>پلتفرم</a>
        </li>
        <li <?= $step == 2 ?'class="active"':''; ?> >
            <a data-toggle="tab" href="#info">اطلاعات برنامه</a>
        </li>
        <li <?= $step == 3?'class="active"':''; ?>>
            <a data-toggle="tab" href="#images">تصاویر برنامه</a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="info" class="tab-pane fade <?= $step == 2?'in active':''; ?>">
            <?php $this->renderPartial('_form', array(
                'model'=>$model,
                'icon' => $icon,
                'app' => $app
            ));
            ?>
        </div>
        <div id="images" class="tab-pane fade <?= $step == 3?'in active':''; ?>">
            <?php $this->renderPartial('_images_form', array(
                'model'=>$model,
                'images' => $images
            ));
            ?>
        </div>
    </div>
</div>