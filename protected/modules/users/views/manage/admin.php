<?php
/* @var $this UsersManageController */
/* @var $model Users */
/* @var $topUser CActiveDataProvider */
/* @var $topDeveloper CActiveDataProvider */

$this->breadcrumbs=array(
    'کاربران'=>array('manage'),
    'مدیریت',
);
?>
<? $this->renderPartial('//layouts/_flashMessage'); ?>
<h1>مدیریت کاربران</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'admins-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'email',
        array(
            'header' => 'نام کامل',
            'value' => '$data->userDetails->fa_name',
            'filter' => CHtml::activeTextField($model,'fa_name')
        ),
        array(
            'header' => 'وضعیت',
            'value' => '$data->statusLabels[$data->status]',
            'filter' => CHtml::activeDropDownList($model,'statusFilter',$model->statusLabels,array('prompt' => 'همه'))
        ),
        array(
            'header' => 'نوع کاربری',
            'value' => '$data->role->name',
            'filter' => CHtml::activeDropDownList($model,'roleId',array('1'=>'کاربر معمولی', '2'=>'توسعه دهنده'),array('prompt' => 'همه'))
        ),
        array(
            'header'=>'امتیاز خرید',
            'value' => 'is_null($data->userDetails->score)?"-":$data->userDetails->score',
        ),
        array(
            'header'=>'امتیاز فروش',
            'value' => 'is_null($data->userDetails->dev_score)?"-":$data->userDetails->dev_score',
        ),
        array(
            'class'=>'CButtonColumn',
            'template' => '{view}{update}{delete}'
        ),
    ),
)); ?>

<h3>برترین کاربر <small>(خریدار)</small></h3>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'admins-grid',
    'dataProvider'=>$topUser,
    'template'=>'{items}',
    'columns'=>array(
        'email',
        array(
            'header' => 'نام کامل',
            'value' => '$data->userDetails->fa_name',
            'filter' => CHtml::activeTextField($model,'fa_name')
        ),
        array(
            'header' => 'وضعیت',
            'value' => '$data->statusLabels[$data->status]',
            'filter' => CHtml::activeDropDownList($model,'statusFilter',$model->statusLabels,array('prompt' => 'همه'))
        ),
        array(
            'header' => 'نوع کاربری',
            'value' => '$data->role->name',
            'filter' => CHtml::activeDropDownList($model,'roleId',array('1'=>'کاربر معمولی', '2'=>'توسعه دهنده'),array('prompt' => 'همه'))
        ),
        array(
            'header'=>'امتیاز خرید',
            'value' => 'is_null($data->userDetails->score)?"-":$data->userDetails->score',
        ),
        array(
            'header'=>'امتیاز فروش',
            'value' => 'is_null($data->userDetails->dev_score)?"-":$data->userDetails->dev_score',
        ),
        array(
            'class'=>'CButtonColumn',
            'template' => '{view}{update}{delete}'
        ),
    ),
)); ?>
<h3>برترین توسعه دهنده<small>(فروشنده)</small></h3>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'admins-grid',
    'dataProvider'=>$topDeveloper,
    'template'=>'{items}',
    'columns'=>array(
        'email',
        array(
            'header' => 'نام کامل',
            'value' => '$data->userDetails->fa_name',
            'filter' => CHtml::activeTextField($model,'fa_name')
        ),
        array(
            'header' => 'وضعیت',
            'value' => '$data->statusLabels[$data->status]',
            'filter' => CHtml::activeDropDownList($model,'statusFilter',$model->statusLabels,array('prompt' => 'همه'))
        ),
        array(
            'header' => 'نوع کاربری',
            'value' => '$data->role->name',
            'filter' => CHtml::activeDropDownList($model,'roleId',array('1'=>'کاربر معمولی', '2'=>'توسعه دهنده'),array('prompt' => 'همه'))
        ),
        array(
            'header'=>'امتیاز خرید',
            'value' => 'is_null($data->userDetails->score)?"-":$data->userDetails->score',
        ),
        array(
            'header'=>'امتیاز فروش',
            'value' => 'is_null($data->userDetails->dev_score)?"-":$data->userDetails->dev_score',
        ),
        array(
            'class'=>'CButtonColumn',
            'template' => '{view}{update}{delete}'
        ),
    ),
)); ?>