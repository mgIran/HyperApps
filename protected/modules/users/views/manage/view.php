<?php
/* @var $this UsersManageController */
/* @var $model Users */

Yii::app()->clientScript->registerCss('imgSize','
.national-card-image
{
	max-width:500px;
	max-height:500px;
}
');

$this->breadcrumbs=array(
	'کاربران'=>array('index'),
	$model->userDetails->fa_name && !empty($model->userDetails->fa_name)?$model->userDetails->fa_name:$model->email,
);

$this->menu=array(
	array('label'=>'مدیرت کاربران', 'url'=>array('admin')),
	array('label'=>'تایید اطلاعات کاربر', 'url'=>array('confirmDeveloper', 'id'=>$model->id)),
	array('label'=>'رد اطلاعات کاربر', 'url'=>array('refuseDeveloper', 'id'=>$model->id)),
	array('label'=>'حذف کاربر', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'آیا از حذف کاربر اطمینان دارید؟')),
);
?>

<h1>نمایش اطلاعات <?php echo $model->userDetails->fa_name && !empty($model->userDetails->fa_name)?$model->userDetails->fa_name:$model->email; ?></h1>


<?php
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'نام',
			'value'=>$model->userDetails->fa_name,
		),
		array(
			'name'=>'نام انگلیسی',
			'value'=>$model->userDetails->en_name,
		),
		array(
			'name'=>'شناسه توسعه دهنده',
			'value'=>$model->userDetails->developer_id,
		),
		array(
			'name'=>'اعتبار',
			'value'=>number_format($model->userDetails->credit,0).'تومان',
		),
		array(
			'name'=>'آدرس وبسایت فارسی',
			'value'=>$model->userDetails->fa_web_url,
		),
		array(
			'name'=>'آدرس وبسایت انگلیسی',
			'value'=>$model->userDetails->en_web_url,
		),
		array(
			'name'=>'شماره تماس',
			'value'=>$model->userDetails->phone,
		),
		array(
			'name'=>'کد ملی',
			'value'=>$model->userDetails->national_code,
		),
		array(
			'name'=>'کد پستی',
			'value'=>$model->userDetails->zip_code,
		),
		array(
			'name'=>'آدرس',
			'value'=>$model->userDetails->address,
		),
		array(
			'name'=>'نوع کاربری',
			'value'=>$model->role->name,
		),
		array(
			'name'=>'تصویر کارت ملی',
			'value'=>CHtml::image(Yii::app()->baseUrl."/uploads/users/national_cards/".$model->userDetails->national_card_image, '', array('class'=>'national-card-image')),
			'type'=>'raw'
		),
		array(
			'name'=>'وضعیت',
			'value'=>$model->statusLabels[$model->status],
		),
		array(
			'name'=>'وضعیت اطلاعات',
			'value'=>$model->userDetails->detailsStatusLabels[$model->userDetails->details_status],
		),
	),
)); ?>

