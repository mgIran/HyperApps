<?php
/* @var $this AppsController */
/* @var $model Apps */
/* @var $form CActiveForm */
?>

<div class="container-fluid">
    <div class="form col-md-5">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'apps-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>true,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    )); ?>

        <p class="note">فیلد های  <span class="required">*</span>دار اجباری هستند.</p>

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
            <?php echo $form->textArea($model,'description',array('placeholder'=>$model->getAttributeLabel('description'),'rows'=>5,'class'=>'form-control')); ?>
            <?php echo $form->error($model,'description'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->textArea($model,'change_log',array('placeholder'=>$model->getAttributeLabel('change_log'),'rows'=>6,'class'=>'form-control','aria-describedby'=>'change-label')); ?>
            <?php echo $form->error($model,'change_log'); ?>
        </div>

        <div class="form-group multipliable-input-container">
            <?php if($model->isNewRecord):?>
                <?php echo CHtml::textField('Apps[permissions][0]','',array('placeholder'=>'دسترسی','class'=>'form-control multipliable-input')); ?>
            <?php else:?>
                <?php foreach(CJSON::decode($model->permissions) as $key=>$permission):?>
                    <?php echo CHtml::textField('Apps[permissions]['.$key.']',$permission,array('placeholder'=>'دسترسی','class'=>'form-control multipliable-input')); ?>
                <?php endforeach;?>
            <?php endif;?>
            <a href="#add-permission" class="add-multipliable-input"><i class="icon icon-plus"></i></a>
            <a href="#remove-permission" class="remove-multipliable-input"><i class="icon icon-trash"></i></a>
            <?php echo $form->error($model,'permissions'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'file_name'); ?>
            <?php echo $form->fileField($model,'file_name'); ?>
            <?php if(!$model->isNewRecord):?>
                <a href="<?php echo $this->createUrl('/apps/download/'.$model->file_name);?>" target="_blank"><?php echo $model->file_name;?></a>
            <?php endif;?>
            <?php echo $form->error($model,'file_name'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'icon'); ?>
            <?php if(!$model->isNewRecord):?>
                <img src="<?php echo Yii::app()->baseUrl.'/uploads/apps/icons/'.$model->icon;?>">
            <?php endif;?>
            <?php echo $form->fileField($model,'icon'); ?>
            <?php echo $form->error($model,'icon'); ?>
        </div>

        <div class="input-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره تغییرات',array('class'=>'btn btn-success')); ?>
        </div>

    <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>