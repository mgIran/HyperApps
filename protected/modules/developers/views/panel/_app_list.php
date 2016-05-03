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
    <div class="col-md-1"><span class="label <?php if($data->confirm=='accepted')echo 'label-success';elseif($data->confirm=='refused' or $data->confirm=='change_required')echo 'label-danger';else echo 'label-info';?>"><?php echo $data->confirmLabels[$data->confirm];?></span></div>
</div>