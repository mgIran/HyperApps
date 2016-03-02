<div class="login-form">
    <h1>
        ورود به حساب کاربری
    </h1>
    <?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
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
        <input class="transition" type="submit" value="ورود">
    </div>
    <?php $this->endWidget(); ?>
    <p>
        <a href="#" class="forget-link">
            رمز عبور خود را فراموش کرده اید؟
        </a>
    </p>
    <p>
        تازه وارد هستید؟
        <a href="<?= Yii::app()->createUrl('//register') ?>" class="register-link">
            ثبت نام کنید
        </a>
    </p>
</div>