<?php
/* @var $this ManageController */
/* @var $model Advertises */
$this->breadcrumbs=array(
		'لیست تبلیغات',
);

$this->menu=array(
		array('label'=>'لیست تبلیغات', 'url'=>array('admin')),
		array('label'=>'افزودن تبلیغات', 'url'=>array('create')),
);

?>

<h1>لیست تبلیغات</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'advertises-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' => 'app_id',
			'value' => '$data->app->title',
			'filter' => CHtml::activeTextField($model,'appFilter')
		),
		array(
			'name' => 'status',
			'value' => '$data->statusLabels[$data->status]',
			'filter' => CHtml::activeDropDownList($model,'status',$model->statusLabels,array('prompt' => '-'))
		),
		array(
			'name' => 'create_date',
			'value' => 'JalaliDate::date("Y/m/d - H:i",$data->create_date)',
			'filter' => false
		),
		array(
			'class'=>'CButtonColumn',
			'buttons' => array(
				'view' => array(
					'url' => 'Yii::app()->createUrl("/apps/{$data->app_id}/".urlencode($data->app->lastPackage->package_name))'
				)
			)
		),
	),
)); ?>
