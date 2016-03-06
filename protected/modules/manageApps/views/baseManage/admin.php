<?php
/* @var $this BaseManageController */
/* @var $model Apps */

$this->breadcrumbs=array(
	'مدیریت',
);
$this->menu=array(
	array('label'=>'افزودن برنامه', 'url'=>Yii::app()->createUrl('/manageApps/'.$this->controller.'/create')),
);
?>

<h1>مدیریت برنامه ها</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'apps-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		array(
			'header' => 'توسعه دهنده',
			'value' => '$data->developer_id && $data->developer->userDetails?$data->developer->userDetails->developer_id:$data->developer_team'
		),
		'category_id',
		'status',
		'price',
		/*
		'file_name',
		'icon',
		'description',
		'change_log',
		'permissions',
		'size',
		'version',
		'confirm',
		*/
		array(
			'class'=>'CButtonColumn',
            'buttons' => array(
                'update' => array(
                    'url' => 'Yii::app()->createUrl("/manageApps/'.$this->controller.'/update", array("id"=>$data->id))'
                ),
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("/manageApps/'.$this->controller.'/delete", array("id"=>$data->id))'
                ),
                'view' => array(
                    'url' => 'Yii::app()->createUrl("/manageApps/'.$this->controller.'/view", array("id"=>$data->id))'
                )
            )
		),
	),
)); ?>
