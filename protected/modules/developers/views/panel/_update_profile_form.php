<?php
/* @var $this PanelController */
/* @var $model UserDetails */
/* @var $form CActiveForm */
?>

<div class="container-fluid">
    <div class="form col-md-5">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'update-profile-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        )
    )); ?>

        <?php echo $form->errorSummary($model); ?>

        <div class="form-group">
            <?php echo $form->textField($model,'fa_name',array('placeholder'=>$model->getAttributeLabel('fa_name').' *','maxlength'=>50,'class'=>'form-control')); ?>
            <p class="desc">نام باید عبارتی با حداکثر 50 حرف باشد که از حروف و اعداد فارسی و انگلیسی، فاصله و نیم‌فاصله تشکیل شده باشد.</p>
            <?php echo $form->error($model,'fa_name'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->textField($model,'fa_web_url',array('placeholder'=>$model->getAttributeLabel('fa_web_url'),'maxlength'=>50,'class'=>'form-control')); ?>
            <?php echo $form->error($model,'fa_web_url'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->textField($model,'en_name',array('placeholder'=>$model->getAttributeLabel('en_name').' *','maxlength'=>50,'class'=>'form-control')); ?>
            <p class="desc">نام باید عبارتی با حداکثر 50 حرف باشد که از حروف و اعداد فارسی و انگلیسی، فاصله و نیم‌فاصله تشکیل شده باشد.</p>
            <?php echo $form->error($model,'en_name'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->textField($model,'en_web_url',array('placeholder'=>$model->getAttributeLabel('en_web_url'),'maxlength'=>50,'class'=>'form-control')); ?>
            <?php echo $form->error($model,'en_web_url'); ?>
        </div>

        <div class="input-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره تغییرات',array('class'=>'btn btn-success')); ?>
        </div>

    <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>