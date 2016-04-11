<?php
/* @var $this PanelController */
/* @var $model UserDetails */
/* @var $form CActiveForm */
/* @var $nationalCardImage Array */
?>

<div class="col-md-6">
    <h1>مشخصات</h1>

    <div class="form update-developer-form">

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

        <div class="alert alert-<?php if($model->details_status=='accepted')echo 'success';elseif($model->details_status=='pending')echo 'warning';else echo 'danger';?>"><?php if($model->details_status=='accepted')echo 'اطلاعات قرارداد مورد تایید می باشد.';elseif($model->details_status=='pending')echo 'اطلاعات قرارداد در حال بررسی است.';else echo 'اطلاعات قرارداد مورد تایید قرار نگرفته است. لطفا اطلاعات صحیح را در فرم زیر وارد کنید.';?></div>
        <div class="alert alert-warning">در صورت تغییر در اطلاعات این فرم حسابتان در صف در انتظار بررسی قرار خواهد گرفت و ممکن است باعث تأخیرهایی در انجام تصفیه‌حسابتان شود.</div>

        <div class="alert alert-info"><?php echo CHtml::label('پست الکترونیکی:&nbsp;&nbsp;', '');?><?php echo $model->user->email;?></div>

        <div class="form-group">
            <?php echo $form->textField($model,'fa_name',array('placeholder'=>$model->getAttributeLabel('fa_name').' *','maxlength'=>50,'class'=>'form-control')); ?>
            <p class="desc">نام باید عبارتی با حداکثر 50 حرف باشد که از حروف و اعداد فارسی و انگلیسی، فاصله و نیم‌فاصله تشکیل شده باشد.</p>
            <?php echo $form->error($model,'fa_name'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->textField($model,'fa_web_url',array('placeholder'=>$model->getAttributeLabel('fa_web_url'),'maxlength'=>255,'class'=>'form-control')); ?>
            <?php echo $form->error($model,'fa_web_url'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->textField($model,'en_name',array('placeholder'=>$model->getAttributeLabel('en_name').' *','maxlength'=>50,'class'=>'form-control')); ?>
            <p class="desc">نام باید عبارتی با حداکثر 50 حرف باشد که از حروف و اعداد فارسی و انگلیسی، فاصله و نیم‌فاصله تشکیل شده باشد.</p>
            <?php echo $form->error($model,'en_name'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->textField($model,'en_web_url',array('placeholder'=>$model->getAttributeLabel('en_web_url'),'maxlength'=>255,'class'=>'form-control')); ?>
            <?php echo $form->error($model,'en_web_url'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->textField($model,'national_code',array('placeholder'=>$model->getAttributeLabel('national_code').' *','maxlength'=>10,'class'=>'form-control')); ?>
            <?php echo $form->error($model,'national_code'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->textField($model,'phone',array('placeholder'=>$model->getAttributeLabel('phone').' *','maxlength'=>11,'class'=>'form-control')); ?>
            <?php echo $form->error($model,'phone'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->textField($model,'zip_code',array('placeholder'=>$model->getAttributeLabel('zip_code').' *','maxlength'=>10,'class'=>'form-control')); ?>
            <?php echo $form->error($model,'zip_code'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->textArea($model,'address',array('placeholder'=>$model->getAttributeLabel('address').' *','maxlength'=>1000,'class'=>'form-control')); ?>
            <?php echo $form->error($model,'address'); ?>
        </div>

        <div class="form-group">
            <?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
                'id' => 'national-card-uploader',
                'model' => $model,
                'name' => 'national_card_image',
                'dictDefaultMessage'=>$model->getAttributeLabel('national_card_image').' را به اینجا بکشید',
                'maxFiles' => 1,
                'maxFileSize' => 0.5, //MB
                'data'=>array('user_id'=>$model->user_id),
                'url' => $this->createUrl('/developers/panel/uploadNationalCardImage'),
                'acceptedFiles' => 'image/jpeg , image/png',
                'serverFiles' => $nationalCardImage,
                'onSuccess' => '
                    var responseObj = JSON.parse(res);
                    if(responseObj.state == "ok")
                    {
                        {serverName} = responseObj.fileName;
                    }else if(responseObj.state == "error"){
                        console.log(responseObj.msg);
                    }
                ',
            ));?>
        </div>

        <div class="input-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره تغییرات',array('class'=>'btn btn-success')); ?>
        </div>

    <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>