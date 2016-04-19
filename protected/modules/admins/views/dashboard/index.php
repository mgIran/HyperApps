<?php
/* @var $this DashboardController*/
/* @var $devIDRequests CActiveDataProvider*/
?>
<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success fade in">
        <button class="close close-sm" type="button" data-dismiss="alert"><i class="icon-remove"></i></button>
        <?php echo Yii::app()->user->getFlash('success');?>
    </div>
<?php elseif(Yii::app()->user->hasFlash('failed')):?>
    <div class="alert alert-danger fade in">
        <button class="close close-sm" type="button" data-dismiss="alert"><i class="icon-remove"></i></button>
        <?php echo Yii::app()->user->getFlash('failed');?>
    </div>
<?php endif;?>
<div class="panel panel-default col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <div class="panel-heading">
        آمار بازدیدکنندگان
    </div>
    <div class="panel-body">
        <p>
            افراد آنلاین : <?php echo Yii::app()->userCounter->getOnline(); ?><br />
            بازدید امروز : <?php echo Yii::app()->userCounter->getToday(); ?><br />
            بازدید دیروز : <?php echo Yii::app()->userCounter->getYesterday(); ?><br />
            تعداد کل بازدید ها : <?php echo Yii::app()->userCounter->getTotal(); ?><br />
            بیشترین بازدید : <?php echo Yii::app()->userCounter->getMaximal(); ?><br />
        </p>
    </div>
</div>
<div class="panel panel-default col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <div class="panel-heading">
        درخواست های تغییر شناسه توسعه دهنده
    </div>
    <div class="panel-body">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'dev-id-requests-grid',
            'dataProvider'=>$devIDRequests,
            'columns'=>array(
                'user_id'=>array(
                    'name'=>'user_id',
                    'value'=>'CHtml::link($data->user->userDetails->fa_name, Yii::app()->createUrl("/users/manage/views/".$data->user->id))',
                    'type'=>'raw'
                ),
                'requested_id',
                array(
                    'class'=>'CButtonColumn',
                    'template' => '{confirm}{delete}',
                    'buttons'=>array(
                        'confirm'=>array(
                            'label'=>'تایید کردن',
                            'url'=>"CHtml::normalizeUrl(array('/users/usersManage/confirmDevID', 'id'=>\$data->user_id))",
                            'imageUrl'=>Yii::app()->theme->baseUrl.'/img/confirm.png',
                        ),
                    ),
                ),
            ),
        ));?>
    </div>
</div>
