<?php
/* @var $this AppsController */
/* @var $labels array */
/* @var $values array */

Yii::app()->clientScript->registerCss('appsStyle','
.report-sale .app-item:nth-child(n+3){
    margin-top: 50px;
}
.report-sale .app-item input[type="radio"]{
    float: right;
    margin-top: 27px;
    margin-left: 15px;
}
.report-sale .app-item img{
    float: right;
    max-width: 70px;
    max-height:70px;
    height:auto;
    margin-left: 15px;
}
.report-canvas{
    margin-top: 50px;
    margin-bottom: 50px;
}
.chart-container{
    margin-top: 50px;
}
.report-sale .panel{
    border: 1px solid #ccc;
}
');
?>

<h1>گزارش فروش</h1>

<div class="report-sale">
<?php echo CHtml::beginForm();?>
    <h4>برنامه مورد نظر را انتخاب کنید:</h4>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php $this->widget('zii.widgets.CListView', array(
                'dataProvider'=>Apps::model()->search(),
                'itemView'=>'_report_sale_app_list',
                'template'=>'{items}'
            ));?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?php echo CHtml::label('از تاریخ', 'from_date');?>
        </div>
        <div class="col-md-4">
            <?php echo CHtml::label('تا تاریخ', 'to_date');?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?php $this->widget('application.extensions.PDatePicker.PDatePicker', array(
                'id'=>'from_date',
                'options'=>array(
                    'format'=>'DD MMMM YYYY'
                ),
                'htmlOptions'=>array(
                    'class'=>'form-control'
                ),
            ));?>
        </div>
        <div class="col-md-4">
            <?php $this->widget('application.extensions.PDatePicker.PDatePicker', array(
                'id'=>'to_date',
                'options'=>array(
                    'format'=>'DD MMMM YYYY'
                ),
                'htmlOptions'=>array(
                    'class'=>'form-control'
                ),
            ));?>
        </div>
        <div class="col-md-4">
            <?php echo CHtml::submitButton('جستجو', array(
                'class'=>'btn btn-info',
                'name'=>'show-chart',
                'id'=>'show-chart',
            ));?>
        </div>
    </div>
<?php if(isset($_POST['from_date_altField'])):?>
    <div class="panel panel-default chart-container">
        <div class="panel-body">
            <h4>نمودار گزارش</h4>
            <?php $this->widget(
                'chartjs.widgets.ChBars',
                array(
                    'width' => 700,
                    'height' => 400,
                    'htmlOptions' => array(
                        'class'=>'center-block report-canvas'
                    ),
                    'labels' => $labels,
                    'datasets' => array(
                        array(
                            "fillColor" => "rgba(54, 162, 235, 0.5)",
                            "strokeColor" => "rgba(54, 162, 235, 1)",
                            "data" => $values
                        )
                    ),
                    'options' => array()
                )
            );?>
        </div>
    </div>
<?php endif;?>
<?php echo CHtml::endForm();?>
</div>
<?php Yii::app()->clientScript->registerScript('submitReport', "
    $('#show-chart').click(function(){
        if($('input[name=\"app_id\"]:checked').length==0){
            alert('لطفا برنامه مورد نظر خود را انتخاب کنید.');
            return false;
        }
    });
");?>