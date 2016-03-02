
<!-- Modal -->
<div id="loginFormModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <a href="#register" class="btn btn-default" id="registerModal" title="ثبت نام" >ثبت نام</a>
                <h4 class="modal-title">حساب کاربری</h4>
            </div>
            <div class="modal-body">
                <div id="loginPage">
                    <div class="login-box col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <p>
                            در صورتی که ثبت نام کرده اید ،                        وارد حساب کاربری خود شوید .
                        </p>
                        <p id="login-error" class="error-message" >

                        </p>
                        <div class="login-lock">
                            <div class="icon icon-2x icon-lock"></div>
                        </div>
                        <div class="login-form">
                            <?php
                            Yii::import('users.models.*');
                            $model=new UserLoginForm;
                            $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'login-modal-form',
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
                                <?= $form->passwordField($model ,'password',array('class' => 'form-control' ,'placeholder' => 'رمز عبور')); ?>
                            </div>
                            <div class="form-group">
                                <?= CHtml::ajaxSubmitButton('ورود',Yii::app()->createUrl('/site/login/'),array(
                                    'type' => 'POST' ,
                                    'data' => 'js:$("#login-modal-form").serialize()',
                                    'dataType' => 'json',
                                    'success' => 'js:function(data){
                                        if(data.state == "ok")
                                            location.reload();
                                        else if(data.state == "error")
                                        {
                                            $("#login-error").html(data.msg);
                                            setInterval(function(){
                                                $("#login-error").html("");
                                            },5000);
                                        }
                                    }'
                                ),array('id' => 'login-submit-btn','class' => 'form-control btn btn-info')); ?>
                            </div>
                            <?
                            $this->endWidget();
                            ?>
                        </div>
                    </div>
                    <div class="ad-link-box col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <p>
                            عضو نیستید ولی قبلا آگهی ثبت کرده اید؟ ایمیل خود را وارد کنید
                        </p>
                        <p class="sm">
                            ایمیلی را که با آن آگهی داده بودید وارد کنید تا لینک مدیریت آگهی برای شما فرستاده شود.
                        </p>
                        <p id="ad-link-msg">
                        </p>
                        <div class="user-icon">
                            <div class="icon icon-2x icon-user"></div>
                        </div>

                        <div class="login-form">
                            <?php $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'ad-link-modal-form',
                                'enableAjaxValidation'=>false,
                                'htmlOptions'=>array(
                                    'onsubmit'=>"return false;",/* Disable normal form submit */
                                ),
                            )); ?>
                            <div class="form-group">
                                <?= CHtml::textField('email','',array('class' => 'form-control','placeholder' => 'پست الکترونیک' )); ?>
                            </div>
                            <div class="form-group">
                                <?= CHtml::ajaxSubmitButton('ارسال لینک مدیریت',Yii::app()->createUrl('/site/sendLink/'),array(
                                    'type' => 'POST' ,
                                    'data' => 'js:$("#ad-link-modal-form").serialize()',
                                    'dataType' => 'json',
                                    'success' => 'js:function(data){
                                        if(data.state == "ok")
                                        {
                                            document.getElementById("ad-link-modal-form").reset();
                                            $("#ad-link-msg").html(data.msg);
                                            $("input[type=\'text\'].form-control").val("");
                                            $("#ad-link-msg").removeClass("error-message").addClass("success-message");
                                            setInterval(function(){
                                                $("#ad-link-msg").html("");
                                            },6000);
                                        }
                                        else if(data.state == "error")
                                        {
                                            $("#ad-link-msg").html(data.msg);
                                            $("#ad-link-msg").removeClass("success-message").addClass("error-message");
                                            setInterval(function(){
                                                $("#ad-link-msg").html("");
                                            },6000);
                                        }
                                    }'
                                ),array('id' => 'ad-link-submit-btn','class' => 'form-control btn btn-success')); ?>
                            </div>
                            <?
                            $this->endWidget();
                            ?>
                        </div>
                    </div>
                </div>
                <div id="registerPage">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="register-form">
                            <p id="register-msg">
                            </p>
                            <?php
                            $model = new Users('create');
                            $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'register-modal-form',
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
                                    'data' => 'js:$("#register-modal-form").serialize()',
                                    'dataType' => 'json',
                                    'success' => 'js:function(data){
                                        if(data.state == "ok")
                                        {
                                            document.getElementById("register-modal-form").reset();
                                            $("#register-msg").html(data.msg);
                                            $("input[type=\'text\'].form-control").val("");
                                            $("#register-msg").removeClass("error-message").addClass("success-message");
                                            setInterval(function(){
                                                $("#register-msg").html("");
                                            },6000);
                                        }
                                        else if(data.state == "error")
                                        {
                                            $("#register-msg").html(data.msg);
                                            $("#register-msg").removeClass("success-message").addClass("error-message");
                                        }
                                    }'
                                ),array('id' => 'register-submit-btn','class' => 'form-control btn btn-info')); ?>
                            </div>
                            <div class="form-group">
                                <a href="#login" id="loginModal" title="ورود به سایت">
                                    بازگشت
                                </a>
                            </div>
                            <?
                            $this->endWidget();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>