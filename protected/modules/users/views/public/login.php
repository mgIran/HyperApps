<div class="login-form">

    <?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
            'afterValidateAttribute' => 'js:function(form, attribute, data, hasError) {
                if(data.UserLoginForm_authenticate_field != undefined)
                    $("#validate-message").text(data.UserLoginForm_authenticate_field[0]).removeClass("hidden");
            }',
        ),
    )); ?>

    <div class="alert alert-danger hidden" id="validate-message">
        <?php echo $form->error($model,'authenticate_field'); ?>
    </div>
    <?php if(Yii::app()->user->hasFlash('success')):?>
        <div class="alert alert-success fade in">
            <?php echo Yii::app()->user->getFlash('success');?>
        </div>
    <?php elseif(Yii::app()->user->hasFlash('fail')):?>
        <div class="alert alert-danger fade in">
            <?php echo Yii::app()->user->getFlash('fail');?>
        </div>
    <?php endif;?>

    <h1>ورود به حساب کاربری</h1>

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