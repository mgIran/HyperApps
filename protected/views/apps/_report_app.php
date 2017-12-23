<?php
/* @var $this AppsController */
/* @var $model Reports */
/* @var $form CActiveForm */
?>
<div id="report-container">
    <?php $this->renderPartial('//layouts/_loading'); ?>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'app-report-form',
        'enableAjaxValidation'=>false,
        'enableClientValidation'=>true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form ,data ,hasError){
                if(!hasError)
                {
                    var loading = $("#report-container .loading-container");
                    var url = \''.Yii::app()->createUrl('/apps/report/?ajax=app-report-form').'\';
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: form.serialize(),
                        dataType: "json",
                        beforeSend: function () {
                            if(loading)
                                loading.show();
                        },
                        success: function (html) {
                            if(loading)
                                loading.hide();
                            if (typeof html === "object" && typeof html.state === \'undefined\') {
                                $.each(html, function (key, value) {
                                    $("#" + key + "_em_").show().html(value.toString()).parent().removeClass(\'success\').addClass(\'error\');
                                });
                            }else if(html.state == \'ok\'){
                                $("#report-container").find(".alert").removeClass("alert-danger hidden").addClass("alert-success").text(\'گزارش شما با موفقیت ثبت گردید.\');   
                            }else{
                                $("#report-container").find(".alert").removeClass("alert-danger hidden").addClass("alert-success").text(\'گزارش شما با موفقیت ثبت گردید.\');
                            }
                            setTimeout(function(){
                                $("#report-container").find(".alert").addClass("hidden").text("");
                            },5000);
                        }
                    });
                }
            }'
        )

    ));?>
        <div class="alert hidden"></div>
        <?= $form->hiddenField($model, 'app_id') ?>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'reason', array('class' => 'control-label')); ?><br>
            <?php echo $form->radioButtonList($model, 'reason', $model->reasons); ?>
            <?php echo $form->error($model, 'reason'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'description', array('class' => 'control-label')); ?>
            <?php echo $form->textArea($model, 'description', array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'description'); ?>
        </div>

        <div class="form-group buttons">
            <button type="button" data-dismiss="modal" class="btn btn-default pull-left">انصراف</button>
            <?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره', array('class'=>'btn btn-success')); ?>
        </div>

    <?php $this->endWidget(); ?>
</div>
