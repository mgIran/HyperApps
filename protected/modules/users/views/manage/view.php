<?php
/* @var $this UsersManageController */
/* @var $model Users */

$this->breadcrumbs=array(
	'کاربران'=>array('index'),
	$model->userDetails->fa_name && !empty($model->userDetails->fa_name)?$model->userDetails->fa_name:$model->email,
);

$this->menu=array(
	array('label'=>'مدیرت کاربران', 'url'=>array('admin')),
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
			'name'=>'نام کاربری',
			'value'=>$model->userDetails->developer_id,
		),
		array(
			'name'=>'اعتبار',
			'value'=>$model->userDetails->credit.'تومان',
		),
		array(
			'name'=>'آدرس وبسایت',
			'value'=>$model->userDetails->fa_web_url,
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
	),
)); ?>

