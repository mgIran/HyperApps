<?php
/* @var $data Apps */
?>

<div class="tr">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5"><?php echo $data->title;?></div>
    <div class="col-lg-1 col-md-1 col-sm-1 hidden-xs"><?php echo ($data->status=='enable')?'فعال':'غیر فعال';?></div>
    <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs"><?php echo ($data->price==0)?'رایگان':number_format($data->price,0).' تومان';?></div>
    <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs"><?= Controller::parseNumbers(number_format($data->install)) ?></div>
    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
        <span style="margin-right: 6px;font-size: 17px">
            <a class="icon-edit text-info" href="<?php echo Yii::app()->createUrl('/developers/apps/update/'.$data->id);?>"></a>
        </span>
        <span style="font-size: 16px">
            <a class="icon-trash text-danger" href="<?php echo Yii::app()->createUrl('/developers/apps/delete/'.$data->id);?>"></a>
        </span>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4"><span class="label <?php if($data->confirm=='accepted')echo 'label-success';elseif($data->confirm=='refused' or $data->confirm=='change_required')echo 'label-danger';else echo 'label-info';?>"><?php echo $data->confirmLabels[$data->confirm];?></span></div>
</div>