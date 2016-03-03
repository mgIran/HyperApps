<?php
/* @var $this PanelController */
/* @var $model UserDevIdRequests */
/* @var $form CActiveForm */
?>

<div class="container-fluid">
    <div class="form col-md-5">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'change-developer-id-form',
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
            <?php echo $form->textField($model,'requested_id',array('placeholder'=>'شناسه درخواستی *','maxlength'=>20,'class'=>'form-control')); ?>
            <p class="desc">شناسهٔ توسعه‌دهنده باید عبارتی با حدّاقل طول ۵ حرف باشد که از حروف a-z و اعداد 0-9، «-» و «ـ» تشکیل شده باشد.<br>بعد از به تأیید رسیدن شناسهٔ انتخابی دیگر نمی‌توانید آن‌را تغییر دهید.</p>
            <?php echo $form->error($model,'requested_id'); ?>
        </div>

        <div class="input-group buttons">
            <?php echo CHtml::submitButton('ارسال',array('class'=>'btn btn-success')); ?>
        </div>

    <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>