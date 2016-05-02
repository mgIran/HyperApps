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
    'id'=>'required-settlements-grid',
    'dataProvider'=>$settlementRequiredUsers,
    'columns'=>array(
        'fa_name'=>array(
            'name'=>'fa_name',
            'value'=>'CHtml::link($data->user->userDetails->fa_name, Yii::app()->createUrl("/users/manage/views/".$data->user->id))',
            'type'=>'raw'
        ),
        'iban'=>array(
            'name'=>'iban',
            'value'=>'"IR".$data->iban'
        ),
        'amount'=>array(
            'header'=>'مبلغ قابل تسویه',
            'value'=>'number_format($data->getSettlementAmount(), 0)." تومان"'
        ),
        'settled'=>array(
            'value'=>'CHtml::ajaxButton("تسویه شد", Yii::app()->createUrl("/developers/panel/manageSettlement"), array(
                "type"=>"POST",
                "dataType"=>"JSON",
                "data"=>"js:{uid:".$data->user_id.", ajax:\"submit-settlement\"}",
                "success"=>"function(data){
                    if(data.status) {
                        $.fn.yiiGridView.update(\'required-settlements-grid\');
                        $.fn.yiiGridView.update(\'settlements-grid\');
                    }
                    else
                        alert(\"در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید.\");
                }"
            ), array(
                "class"=>"btn btn-success",
                "id"=>"btn-settled-".$data->user_id
            ))',
            'type'=>'raw'
        ),
    ),
));?>