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

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'developer_team'); ?>
		<?php echo $form->textField($model,'developer_team',array('size'=>50,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'developer_team'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php echo $form->dropDownList($model,'category_id',AppCategories::model()->sortList());
        ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',array(
				'enable' => 'فعال',
				'disable' => 'غیر فعال'
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
            'serverFiles' => $icon,
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
		<?php
		$this->widget('ext.ckeditor.CKEditor',array(
			'model' => $model,
			'attribute' => 'description'
		));
		?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'change_log'); ?>
		<?php
		$this->widget('ext.ckeditor.CKEditor',array(
				'model' => $model,
				'attribute' => 'change_log'
		));
		?>
		<?php echo $form->error($model,'change_log'); ?>
	</div>

	<div class="form-group multipliable-input-container">
		<?php echo CHtml::label('لیست دسترسی های برنامه',''); ?>
		<?php if($model->isNewRecord):?>
			<?php echo CHtml::textField('Apps[permissions][0]','',array('placeholder'=>'دسترسی','class'=>'form-control multipliable-input')); ?>
		<?php else:
			if($model->permissions) {
				?>
				<?php
				foreach (CJSON::decode($model->permissions) as $key => $permission):
					?>
					<?php echo CHtml::textField('Apps[permissions][' . $key . ']', $permission, array('placeholder' => 'دسترسی', 'class' => 'form-control multipliable-input')); ?>
				<?php
				endforeach;
				?>
				<?php
			}else
			{
				echo CHtml::textField('Apps[permissions][0]','',array('placeholder'=>'دسترسی','class'=>'form-control multipliable-input'));
			}
		endif;?>
		<a href="#add-permission" class="add-multipliable-input"><i class="icon icon-plus"></i></a>
		<a href="#remove-permission" class="remove-multipliable-input"><i class="icon icon-trash"></i></a>
		<?php echo $form->error($model,'permissions'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش' ,array('class' => 'btn btn-success')); ?>
	</div>

<?php  $this->endWidget(); ?>

</div><!-- form -->