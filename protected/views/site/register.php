<div class="login-form signup">
    <h1>
        ثبت نام
    </h1>
    <?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'register-form',
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>
    <div class="row">
        <?php echo $form->textField($model,'email',array('class'=>'transition focus-left','placeholder'=>'پست الکترونیکی')); ?>
        <?php echo $form->error($model,'email'); ?>
        <span class="transition icon-envelope"></span>
    </div>
    <div class="row">
        <?php echo $form->passwordField($model,'password',array('class'=>'transition','placeholder'=>'رمز عبور')); ?>
        <?php echo $form->error($model,'password'); ?>
        <span class="transition icon-key"></span>
    </div>
    <div class="row">
        <?php echo $form->passwordField($model,'repeatPassword',array('class'=>'transition','placeholder'=>'تکرار رمز عبور')); ?>
        <?php echo $form->error($model,'repeatPassword'); ?>
        <span class="transition icon-key"></span>
    </div>
    <div class="row">
        <input class="transition" type="submit" value="ثبت نام">
    </div>
    <?php $this->endWidget(); ?>
</div>
