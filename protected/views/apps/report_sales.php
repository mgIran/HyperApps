<?php
/* @var $this AppsController */
/* @var $labels array */
/* @var $values array */
/* @var $showChart boolean */
/* @var $activeTab string */

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

<ul class="nav nav-tabs">
    <li <?php if($activeTab=='monthly'):?>class="active"<?php endif;?>><a data-toggle="tab" href="#monthly">ماهیانه</a></li>
    <li <?php if($activeTab=='yearly'):?>class="active"<?php endif;?>><a data-toggle="tab" href="#yearly">سالیانه</a></li>
    <li <?php if($activeTab=='by-program'):?>class="active"<?php endif;?>><a data-toggle="tab" href="#by-program">بر اساس برنامه</a></li>
    <li <?php if($activeTab=='by-developer'):?>class="active"<?php endif;?>><a data-toggle="tab" href="#by-developer">بر اساس توسعه دهنده</a></li>
</ul>

<div class="tab-content report-sale">
    <div id="monthly" class="tab-pane<?php if($activeTab=='monthly'):?> fade in active<?php endif;?>">
        <?php $this->renderPartial('_report_monthly', array('labels'=>$labels,'values'=>$values)); ?>
    </div>
    <div id="yearly" class="tab-pane<?php if($activeTab=='yearly'):?> fade in active<?php endif;?>">
        <?php $this->renderPartial('_report_yearly', array('labels'=>$labels,'values'=>$values)); ?>
    </div>
    <div id="by-program" class="tab-pane<?php if($activeTab=='by-program'):?> fade in active<?php endif;?>">
        <?php $this->renderPartial('_report_by_program', array('labels'=>$labels,'values'=>$values)); ?>
    </div>
    <div id="by-developer" class="tab-pane<?php if($activeTab=='by-developer'):?> fade in active<?php endif;?>">
        <?php $this->renderPartial('_report_by_developer', array('labels'=>$labels,'values'=>$values)); ?>
    </div>
</div>

<?php if($showChart):?>
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