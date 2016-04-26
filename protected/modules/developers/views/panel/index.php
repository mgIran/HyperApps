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
                <div class="col-md-3">عنوان برنامه</div>
                <div class="col-md-1">وضعیت</div>
                <div class="col-md-1">قیمت</div>
                <div class="col-md-2">فروش</div>
                <div class="col-md-2">تعداد نصب شده</div>
                <div class="col-md-2">امتیاز</div>
                <div class="col-md-1">تاییدیه</div>
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