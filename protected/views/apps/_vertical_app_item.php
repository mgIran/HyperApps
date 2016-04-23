<?php
/* @var $this AppsController */
/* @var $data Apps */
?>

<div class="app-details">
    <div class="pic">
        <img src="<?= Yii::app()->baseUrl.'/uploads/apps/icons/'.CHtml::encode($data->icon); ?>">
    </div>
    <div class="app-content">
        <div class="title">
            <a href="<?php echo $this->createUrl('/apps/'.CHtml::encode($data->id).'/'.CHtml::encode($data->title));?>"><?php echo CHtml::encode($data->title);?></a>
        </div>
        <div class="title" >
            <span class="text-right green col-lg-6 col-md-6 col-sm-6 col-xs-6" >
                <?php if($data->price==0):?>
                    <a href="<?php echo Yii::app()->createUrl('/apps/free')?>">رایگان</a>
                <?php else:?>
                    <a><?php echo number_format(CHtml::encode($data->price), 0).' تومان';?></a>
                <?php endif;?>
            </span>
            <span class="ltr text-left app-rate col-lg-6 col-md-6 col-sm-6 col-xs-6 pull-left" >
                <span class="icon-star"></span>
                <span class="icon-star"></span>
                <span class="icon-star"></span>
                <span class="icon-star-half-empty"></span>
                <span class="icon-star-empty"></span>
            </span>
        </div>
        <div class="app-desc">
            <?php
            $text = strip_tags($data->description);
            $length = mb_strlen($text,'utf8');
            $words = explode(" ", $text);
            $c = count($words);
            if($c > 20)
                for($i = 1; $i <= 20; $i++)
                    echo CHtml::encode($words[$i]);
            else
                echo CHtml::encode($data->description);
            ?>
            <span class="paragraph-end"></span>
        </div>
    </div>
    <div class="app-footer">
        <span class="col-lg-4 col-md-4 col-sm-4 hidden-xs"><?php echo number_format($data->install, 0).' دانلود';?></span>
        <span class="col-lg-4 col-md-4 col-sm-4 hidden-xs"><?php echo CHtml::encode(round($data->size/1024,1).' کیلوبایت');?></span>
        <span class="col-lg-4 col-md-4 col-sm-4 hidden-xs green"><?php echo (is_null($data->developer_id) or empty($data->developer_id))?CHtml::encode($data->developer_team):CHtml::encode($data->developer->userDetails->fa_name);?></span>
    </div>
</div>