<?php
/* @var $this AppsController */
/* @var $model Apps */
/* @var $imageModel AppImages */
/* @var $images [] */


if(isset($_GET['step']) && !empty($_GET['step']))
    $step = (int)$_GET['step'];
?>

<div class="container">
    <h3>ویرایش برنامه <?= $model->title; ?></h3>
    <ul class="nav nav-tabs">
        <li <?= $step == 1 ?'class="active"':''; ?> >
            <a data-toggle="tab" href="#info">اطلاعات برنامه</a>
        </li>
        <li <?= $step == 2?'class="active"':''; ?>>
            <a data-toggle="tab" href="#images">تصاویر برنامه</a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="info" class="tab-pane fade <?= $step == 1?'in active':''; ?>">
            <?php $this->renderPartial('_form', array(
                'model'=>$model,
                'icon' => $icon,
                'app' => $app
            ));
            ?>
        </div>
        <div id="images" class="tab-pane fade <?= $step == 2?'in active':''; ?>">
            <?php $this->renderPartial('_images_form', array(
                'model'=>$model,
                'imageModel'=>$imageModel,
                'images' => $images
            ));
            ?>
        </div>
    </div>
</div>