<?php
/* @var $data Apps */
?>

<div class="tr">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-5"><?php echo $data->title;?></div>
    <div class="col-lg-1 col-md-1 col-sm-1 hidden-xs"><?php echo ($data->status=='enable')?'فعال':'غیر فعال';?></div>
    <div class="col-lg-1 col-md-1 col-sm-2 hidden-xs"><?php echo ($data->price==0)?'رایگان':number_format($data->price,0).' تومان';?></div>
    <div class="col-lg-1 col-md-1 col-sm-1 hidden-xs">0</div>
    <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs">0</div>
    <div class="col-lg-1 col-md-1 hidden-sm hidden-xs">0</div>
    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
        <span class="pull-left" style="margin-right: 6px;font-size: 17px">
            <a class="icon-edit text-info" href="<?php echo Yii::app()->createUrl('/developers/apps/update/'.$data->id);?>"></a>
        </span>
        <span class="pull-left" style="font-size: 16px">
            <a class="icon-trash text-danger" href="<?php echo Yii::app()->createUrl('/developers/apps/delete/'.$data->id);?>"></a>
        </span>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4"><span class="label <?php if($data->confirm=='accepted')echo 'label-success';elseif($data->confirm=='refused')echo 'label-danger';else echo 'label-info';?>"><?php if($data->confirm=='accepted')echo 'تایید شده';elseif($data->confirm=='refused')echo 'رد شده';else echo 'در حال بررسی';?></span></div>
</div>