<?php
/* @var $this PanelController */
/* @var $appsDataProvider CActiveDataProvider */
?>
<div class="container dashboard-container">
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="<?php echo $this->createUrl('/developers/panel');?>">برنامه ها</a>
        </li>
        <li>
            <a href="<?php echo $this->createUrl('/developers/panel/account');?>">حساب توسعه دهنده</a>
        </li>
        <li>
            <a href="<?php echo $this->createUrl('/developers/panel/sales');?>">گزارش فروش</a>
        </li>
        <li>
            <a href="<?php echo $this->createUrl('/developers/panel/settlement');?>">تسویه حساب</a>
        </li>
        <li>
            <a href="/developers/panel/support/?l=fa">پشتیبانی</a>
        </li>
        <li>
            <a href="/developers/panel/docs/?l=fa" target="_blank">مستندات</a>
        </li>
    </ul>
    <a class="btn btn-success developer-signup-link" href="<?php echo Yii::app()->createUrl('/dashboard')?>">پنل کاربری</a>
    <div class="tab-content card-container">
        <div class="tab-pane active">
            <a class="btn btn-success" href="<?php echo $this->createUrl('/developers/apps/create');?>"><i class="icon icon-plus"></i> افزودن برنامه جدید</a>
        </div>
        <div class="table text-center">
            <div class="thead">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">عنوان برنامه</div>
                <div class="col-lg-1 col-md-1 col-sm-1 hidden-xs">وضعیت</div>
                <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs">قیمت</div>
                <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs">تعداد نصب شده</div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">عملیات</div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">تاییدیه</div>
            </div>
            <div class="tbody">
                <?php $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$appsDataProvider,
                    'itemView'=>'_app_list',
                    'template'=>'{items}'
                ));?>
            </div>
        </div>
    </div>
</div>