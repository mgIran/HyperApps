<?php
/* @var $this AppsController */
/* @var $model Apps */
/* @var $form CActiveForm */
?>

<div class="container-fluid">
    <div class="form col-md-5">

        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'apps-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation'=>true,
            'enableClientValidation'=>true,
            'clientOptions' => array(
                'validateOnSubmit' => true
            )
        )); ?>
        <p class="errorMessage">
            <?php if(Yii::app()->user->hasFlash('failed')) echo Yii::app()->user->getFlash('failed'); ?>
        </p>
        <div class="form-group">
            <?php echo CHtml::dropDownList('platform_id',$model->platform_id,CHtml::listData(AppPlatforms::model()->findAll(), 'id', 'title'),array('prompt'=>'لطفا پلتفرم مورد نظر را انتخاب کنید *','class'=>'form-control')); ?>
            <?php echo $form->error($model,'platform_id'); ?>
        </div>

        <div class="input-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره تغییرات',array('class'=>'btn btn-success')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>