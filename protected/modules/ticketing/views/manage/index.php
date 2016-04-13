<?php
/* @var $this TicketsManageController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tickets',
);
$this->menu=array(
	array('label'=>'افزودن ', 'url'=>array('create')),
	array('label'=>'مدیریت ', 'url'=>array('admin')),
);
?>
<div class="panel panel-default rtl col-lg-12 col-md-12 col-sm-12 col-xs-12 index " >
    <div class="panel-body">
        <h2 class="page-header">
            پشتیبانی
        </h2>
        <div class="content">
            <div class="login-box col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 float-none">
                    <p>
                        برای ارسال تیکت به بخش پشتیبانی ابتدا وارد حساب کاربری خود شوید.
                    </p>
                    <p id="login-error-page" class="error-message" >

                    </p>
                    <div class="login-lock">
                        <div class="icon icon-2x icon-lock"></div>
                    </div>
                    <div class="login-form">
                        <?php
                        Yii::import('users.models.*');
                        $model=new UserLoginForm;
                        $form=$this->beginWidget('CActiveForm', array(
                            'id'=>'login-modal-form-page',
                            'enableAjaxValidation'=>true,
                            'htmlOptions'=>array(
                                'onsubmit'=>"return false;",/* Disable normal form submit */
                            ),
                        ));
                        echo CHtml::hiddenField('ajaxReq',1);
                        ?>
                        <div class="form-group">
                            <?= $form->emailField($model ,'email',array('class' => 'form-control','placeholder' => 'پست الکترونیک' )); ?>
                        </div>
                        <div class="form-group">
                            <?= $form->passwordField($model ,'password',array('class' => 'form-control' ,'placeholder' => 'کلمه عبور')); ?>
                        </div>
                        <div class="form-group">
                            <?= CHtml::ajaxSubmitButton('ورود',Yii::app()->createUrl('/site/login/'),array(
                                'type' => 'POST' ,
                                'data' => 'js:$("#login-modal-form-page").serialize()',
                                'dataType' => 'json',
                                'success' => 'js:function(data){
                                            if(data.state == "ok")
                                                location.reload();
                                            else if(data.state == "error")
                                            {
                                                $("#login-error-page").html(data.msg);
                                                setInterval(function(){
                                                    $("#login-error-page").html("");
                                                },5000);
                                            }
                                        }'
                            ),array('id' => 'login-submit-btn-page','class' => 'form-control btn btn-info')); ?>
                        </div>
                        <?
                        $this->endWidget();
                        ?>
                    </div>
                </div>
            </div>
            <div class="ad-link-box col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="register-form col-lg-10 col-md-10 col-sm-10 col-xs-12 float-none">
                    <p>
                        در صورتی که عضو سایت نیستید ،می توانید از طریق فرم زیر اقدام کنید .
                    </p>
                    <p id="register-msg-page">
                    </p>
                    <div class="user-icon">
                        <div class="icon icon-2x icon-user"></div>
                    </div>
                    <?php
                    $model = new Users('create');
                    $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'register-modal-form-page',
                        'enableAjaxValidation'=>false,
                        'htmlOptions'=>array(
                            'onsubmit'=>"return false;",/* Disable normal form submit */
                        ),
                    )); ?>
                    <div class="form-group">
                        <?= $form->emailField($model ,'email',array('class' => 'form-control','placeholder' => $model->getAttributeLabel('email'))); ?>
                    </div>
                    <div class="form-group">
                        <?= $form->passwordField($model ,'password',array('class' => 'form-control','placeholder' => $model->getAttributeLabel('password'))); ?>
                    </div>
                    <div class="form-group">
                        <?= $form->passwordField($model ,'repeatPassword',array('class' => 'form-control','placeholder' => $model->getAttributeLabel('repeatPassword'))); ?>
                    </div>

                    <div class="form-group">
                        <?= CHtml::ajaxSubmitButton('ثبت نام',Yii::app()->createUrl('/site/register/'),array(
                            'type' => 'POST' ,
                            'data' => 'js:$("#register-modal-form-page").serialize()',
                            'dataType' => 'json',
                            'success' => 'js:function(data){
                                        if(data.state == "ok")
                                        {
                                            document.getElementById("register-modal-form-page").reset();
                                            $("#register-msg-page").html(data.msg);
                                            $("input[type=\'text\'].form-control").val("");
                                            $("#register-msg-page").removeClass("error-message").addClass("success-message");
                                            setInterval(function(){
                                                $("#register-msg-page").html("");
                                            },6000);
                                        }
                                        else if(data.state == "error")
                                        {
                                            $("#register-msg-page").html(data.msg);
                                            $("#register-msg-page").removeClass("success-message").addClass("error-message");
                                        }
                                    }'
                        ),array('id' => 'register-submit-btn-page','class' => 'form-control btn btn-success')); ?>
                    </div>
                    <?
                    $this->endWidget();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>