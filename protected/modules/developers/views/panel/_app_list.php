<?php
/* @var $data Apps */
?>

<div class="tr">
    <div class="col-md-3"><?php echo $data->title;?></div>
    <div class="col-md-1"><?php echo ($data->status=='enable')?'فعال':'غیر فعال';?></div>
    <div class="col-md-1"><?php echo ($data->price==0)?'رایگان':number_format($data->price,0).' تومان';?></div>
    <div class="col-md-2">0</div>
    <div class="col-md-2">0</div>
    <div class="col-md-2">0</div>
    <div class="col-md-1"><span class="label <?php if($data->confirm=='accepted')echo 'label-success';elseif($data->confirm=='refused')echo 'label-danger';else echo 'label-info';?>"><?php if($data->confirm=='accepted')echo 'تایید شده';elseif($data->confirm=='refused')echo 'رد شده';else echo 'در حال بررسی';?></span></div>
</div>