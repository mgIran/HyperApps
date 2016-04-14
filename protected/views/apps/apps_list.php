<?php
/* @var $this AppsController */
/* @var $dataProvider CActiveDataProvider */
/* @var $title String */
/* @var $pageTitle String */
?>

<div class="app-box">
    <div class="top-box">
        <div class="title pull-right">
            <h2><?php echo CHtml::encode($pageTitle).((!is_null($title))?'ی '.CHtml::encode($title):null)?></h2>
        </div>
    </div>
    <?php $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$dataProvider,
        'id'=>'newest-programs',
        'itemView'=>'//site/_app_item',
        'template'=>'{items}',
        'itemsCssClass'=>'app-carousel'
    ));?>
</div>