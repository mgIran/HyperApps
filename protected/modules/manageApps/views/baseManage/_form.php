<?php
/* @var $this BaseManageController */
/* @var $model Apps */
/* @var $form CActiveForm */
?>

<div class="form">

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
)); ?>

	<p class="note">فیلد های دارای <span class="required">*</span> الزامی هستند.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'developer_team'); ?>
		<?php echo $form->textField($model,'developer_team',array('size'=>10,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'developer_team'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php
        $this->widget('ext.dropdown.dropDown' ,array(
            'id' => 'category',
            'model' => $model,
            'attribute' => 'category_id',
            'data' => CHtml::listData(AppCategories::model()->findAll(),'id' ,'fullName'),
            'label' => 'دسته بندی',
            'selected' => $model->category_id?$model->category_id:false,
            'caret' => '<i class="icon icon-chevron-down"></i>',
        ));
        ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php
        $this->widget('ext.dropdown.dropDown' ,array(
            'id' => 'status',
            'model' => $model,
            'attribute' => 'status',
            'data' => array(
                1 => 'فعال',
                0 => 'غیر فعال'
            ),
            'label' => 'وضعیت',
            'selected' => $model->status?$model->status:false,
            'caret' => '<i class="icon icon-chevron-down"></i>',
        ));
        ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'file_name'); ?>
        <?php
        $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
            'id' => 'uploaderFile',
            'model' => $model,
            'name' => 'file_name',
            'maxFileSize' => 100,
            'maxFiles' => 1,
            'url' => Yii::app()->createUrl('/manageApps/'.$this->controller.'/uploadFile'),
            'deleteUrl' => Yii::app()->createUrl('/manageApps/'.$this->controller.'/deleteUploadFile'),
            'acceptedFiles' => $this->formats,
            'serverFiles' => $file,
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

	<div class="row">
		<?php echo $form->labelEx($model,'icon'); ?>
        <?php
        $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
            'id' => 'uploaderIcon',
            'model' => $model,
            'name' => 'icon',
            'maxFiles' => 1,
            'maxFileSize' => 2, //MB
            'url' => Yii::app()->createUrl('/manageApps/'.$this->controller.'/upload'),
            'deleteUrl' => Yii::app()->createUrl('/manageApps/'.$this->controller.'/deleteUpload'),
            'acceptedFiles' => 'image/jpeg , image/png',
            'serverFiles' => $image,
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

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'change_log'); ?>
		<?php echo $form->textArea($model,'change_log',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'change_log'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'permissions'); ?>
		<?php echo $form->textArea($model,'permissions',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'permissions'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'size'); ?>
		<?php echo $form->textField($model,'size'); ?>
		<?php echo $form->error($model,'size'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'version'); ?>
		<?php echo $form->textField($model,'version',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'version'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'confirm'); ?>
		<?php echo $form->textField($model,'confirm'); ?>
		<?php echo $form->error($model,'confirm'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش'); ?>
	</div>

<?php  $this->endWidget(); ?>

</div><!-- form -->