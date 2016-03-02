<?php
/* @var $this PanelController */
/* @var $appsDataProvider CActiveDataProvider */
?>
<div class="container">
    <ul class="nav nav-tabs">
        <li class=" active">
            <a href="<?php echo $this->createUrl('/developers/panel')?>">برنامه ها</a>
        </li>
        <li>
            <a href="/developers/panel/account/?l=fa">حساب توسعه دهنده</a>
        </li>
        <li>
            <a href="/developers/panel/financial/?l=fa">امور مالی و فروش</a>
        </li>
        <li>
            <a href="/developers/panel/support/?l=fa">پشتیبانی</a>
        </li>
        <li>
            <a href="/developers/panel/docs/?l=fa" target="_blank">مستندات</a>
        </li>
    </ul>

    <div class="tab-content card-container padded">
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