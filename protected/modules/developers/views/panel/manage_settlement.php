<?php
/* @var $this PanelController*/
/* @var $settlementHistory CActiveDataProvider*/
/* @var $settlementRequiredUsers CActiveDataProvider*/
?>
<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success fade in">
        <button class="close close-sm" type="button" data-dismiss="alert"><i class="icon-remove"></i></button>
        <?php echo Yii::app()->user->getFlash('success');?>
    </div>
<?php endif;?>
<?php echo CHtml::beginForm();?>
    <?php echo CHtml::submitButton('امور مالی این ماه تسویه شد', array(
        'class'=>'btn btn-success',
        'name'=>'submit'
    ));?>
<?php echo CHtml::endForm();?>
<h3>تاریخچه تسویه حساب ها</h3>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'settlements-grid',
    'dataProvider'=>$settlementHistory,
    'columns'=>array(
        'date'=>array(
            'name'=>'date',
            'value'=>'JalaliDate::date("d F Y", $data->date)'
        ),
        'amount'=>array(
            'name'=>'amount',
            'value'=>'number_format($data->amount, 0)." تومان"'
        ),
    ),
));?>
<h3>کاربرانی که درخواست تسویه حساب دارند</h3>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'requeired-settlements-grid',
    'dataProvider'=>$settlementRequiredUsers,
    'columns'=>array(
        'fa_name'=>array(
            'name'=>'fa_name',
            'value'=>'CHtml::link($data->user->userDetails->fa_name, Yii::app()->createUrl("/users/manage/views/".$data->user->id))',
            'type'=>'raw'
        ),
        'iban',
    ),
));?>