<?php
/* @var $this ManageController */
/* @var $model Advertises */
/* @var $form CActiveForm */
/* @var $cover array */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'advertises-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
));
$apps = array();
if($model->isNewRecord) {
	// get valid apps for advertising
	$criteria = Apps::model()->getValidApps();
	$criteria->together = true;
	$criteria->with[] = 'advertise';
	$criteria->addCondition('advertise.app_id IS NULL');
    $apps = Apps::model()->findAll($criteria);

}
if(!$model->isNewRecord || $apps) {
	?>

	<div class="row">
		<?php echo $form->labelEx($model, 'app_id'); ?>
		<?
		if(!$model->isNewRecord)
			echo CHtml::textField('',$model->app->title,array('disabled'=>true));
		else
			echo $form->dropDownList($model, 'app_id', CHtml::listData($apps, 'id', 'title'));
		?>
		<?php echo $form->error($model, 'app_id'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model, 'cover'); ?>
        <?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
            'id' => 'uploaderAd',
            'model' => $model,
            'name' => 'cover',
            'maxFiles' => 1,
            'maxFileSize' => 1, //MB
            'url' => Yii::app()->createUrl('/advertises/manage/upload'),
            'deleteUrl' => Yii::app()->createUrl('/advertises/manage/deleteUpload'),
            'acceptedFiles' => 'image/*',
            'serverFiles' => $cover,
            'onSuccess' => '
                var responseObj = JSON.parse(res);
                if(responseObj.state == "ok")
                {
                    {serverName} = responseObj.fileName;
                }else if(responseObj.state == "error"){
                    alert(responseObj.msg);
                    this.removeFile(file);
                }
            ',
        )); ?>
        <small>- اندازه تصویر باید 540 × 1080 پیکسل باشد.</small>
        <?php echo $form->error($model, 'cover'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model, 'status'); ?>
		<?php echo $form->dropDownList($model, 'status', $model->statusLabels); ?>
		<?php echo $form->error($model, 'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره', array('class'=>'btn btn-success')); ?>
	</div>

	<?php $this->endWidget(); ?>
<?
}else
	echo '<h4>برنامه ای برای تبلیغ وجود ندارد.</h4>';
?>
</div><!-- form -->
