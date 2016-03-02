<?php
if(Yii::app()->user->hasFlash('failed'))
    echo '<div class=\'alert alert-danger fade in\'>
            <button class=\'close close-sm\' type=\'button\' data-dismiss=\'alert\'><i class=\'icon-remove\'></i></button>
            '.Yii::app()->user->getFlash('failed').'
        </div>';
?>
<?php
/* @var $this PlacesManageController */
/* @var $model Places */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'places-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">فیلد های دارای <span class="required">*</span> الزامی هستند.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo CHtml::label('استان',''); ?>
		<?php echo $form->dropDownList($model,'town_id',CHtml::listData(Towns::model()->findAll() ,'id','name')); ?>
		<?php echo $form->error($model,'town_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش',array('class'=>'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->