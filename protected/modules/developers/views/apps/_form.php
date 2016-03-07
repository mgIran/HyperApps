<?php
/* @var $this AppsController */
/* @var $model Apps */
/* @var $form CActiveForm */
?>

<div class="container-fluid">
    <div class="form col-md-6">

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
    ));
    echo $form->hiddenField($model,'platform_id');
    ?>

        <?php echo $form->errorSummary($model); ?>

        <div class="form-group">
            <?php echo $form->textField($model,'title',array('placeholder'=>$model->getAttributeLabel('title').' *','maxlength'=>50,'class'=>'form-control')); ?>
            <?php echo $form->error($model,'title'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->dropDownList($model,'category_id',CHtml::listData(AppCategories::model()->findAll(), 'id', 'title'),array('prompt'=>'لطفا دسته مورد نظر را انتخاب کنید *','class'=>'form-control')); ?>
            <?php echo $form->error($model,'category_id'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->dropDownList($model,'status',array('enable'=>'فعال','disable'=>'غیرفعال',),array('class'=>'form-control')); ?>
            <?php echo $form->error($model,'status'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->textField($model,'price',array('placeholder'=>$model->getAttributeLabel('price').' (تومان) *','class'=>'form-control')); ?>
            <?php echo $form->error($model,'price'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->textField($model,'version',array('placeholder'=>$model->getAttributeLabel('version').' *','class'=>'form-control')); ?>
            <?php echo $form->error($model,'version'); ?>
        </div>

        <div class="form-group">
            <?php
            $this->widget('ext.ckeditor.CKEditor',array(
                'model' => $model,
                'attribute' => 'description',
                'config' =>'basic'
            ));
            ?>
            <?php echo $form->error($model,'description'); ?>
        </div>

        <div class="form-group">
            <?php
            $this->widget('ext.ckeditor.CKEditor',array(
                'model' => $model,
                'attribute' => 'change_log',
                'config' =>'basic'
            ));
            ?>
            <?php echo $form->error($model,'change_log'); ?>
        </div>

        <div class="form-group multipliable-input-container">
            <?php if($model->isNewRecord):?>
                <?php echo CHtml::textField('Apps[permissions][0]','',array('placeholder'=>'دسترسی','class'=>'form-control multipliable-input')); ?>
            <?php else:?>
                <?php
                if($model->permissions) {
                    foreach(CJSON::decode($model->permissions) as $key => $permission):?>
                        <?php echo CHtml::textField('Apps[permissions]['.$key.']', $permission, array('placeholder' => 'دسترسی', 'class' => 'form-control multipliable-input')); ?>
                        <?php
                    endforeach;
                }
                else {
                    echo CHtml::textField('Apps[permissions][0]','',array('placeholder'=>'دسترسی','class'=>'form-control multipliable-input'));
                }
                ?>
            <?php endif;?>
            <a href="#add-permission" class="add-multipliable-input"><i class="icon icon-plus"></i></a>
            <a href="#remove-permission" class="remove-multipliable-input"><i class="icon icon-trash"></i></a>
            <?php echo $form->error($model,'permissions'); ?>
        </div>

        <div class="form-group col-md-6">
            <?php echo $form->labelEx($model,'file_name',array('class'=> 'block')); ?>
            <?php
            $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
                'id' => 'uploaderFile',
                'model' => $model,
                'name' => 'file_name',
                'maxFileSize' => 1024,
                'maxFiles' => 1,
                'url' => Yii::app()->createUrl('/developers/apps/uploadFile'),
                'deleteUrl' => Yii::app()->createUrl('/developers/apps/deleteUploadFile'),
                'acceptedFiles' => $this->formats,
                'data' => array(
                    'filesFolder' => $model->platform->name
                ),
                'serverFiles' => $app,
                'onSuccess' => '
                var responseObj = JSON.parse(res);
                if(responseObj.state == "ok")
                {
                    {serverName} = responseObj.fileName;
                }else if(responseObj.state == "error"){
                    console.log(responseObj.msg);
                }
            ',
            ));
            ?>
            <?php echo $form->error($model,'file_name'); ?>
        </div>

        <div class="form-group col-md-6">
            <?php echo $form->labelEx($model,'icon',array('class'=> 'block')); ?>
            <?php
            $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
                'id' => 'uploaderIcon',
                'model' => $model,
                'name' => 'icon',
                'maxFiles' => 1,
                'maxFileSize' => 0.2, //MB
                'url' => Yii::app()->createUrl('/developers/apps/upload'),
                'deleteUrl' => Yii::app()->createUrl('/developers/apps/deleteUpload'),
                'acceptedFiles' => 'image/jpeg , image/png',
                'serverFiles' => $icon,
                'data' => array(
                    'filesFolder' => $model->platform->name
                ),
                'onSuccess' => '
                var responseObj = JSON.parse(res);
                if(responseObj.state == "ok")
                {
                    {serverName} = responseObj.fileName;
                }else if(responseObj.state == "error"){
                    console.log(responseObj.msg);
                }
            ',
            ));
            ?>
            <?php echo $form->error($model,'icon'); ?>
        </div>
        <br>
        <div class="input-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره تغییرات',array('class'=>'btn btn-success')); ?>
        </div>

    <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>