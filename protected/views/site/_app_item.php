<?php
/* @var $data Apps */
?>

<div class="app-item">
    <div class="app-item-content">
        <div class="pic">
            <div>
                <a href="<?php echo Yii::app()->createUrl('/apps/'.$data->id.'/'.urlencode($data->lastPackage->package_name));?>">
                    <img src="<?php echo Yii::app()->baseUrl.'/uploads/apps/icons/'.CHtml::encode($data->icon);?>">
                </a>
            </div>
        </div>
        <div class="detail">
            <div class="app-title">
                <a href="<?php echo Yii::app()->createUrl('/apps/'.$data->id.'/'.urlencode($data->lastPackage->package_name));?>">
                    <?php echo CHtml::encode($data->title);?>
                    <span class="paragraph-end"></span>
                </a>
            </div>
            <div class="app-any">
                <span class="app-price">
                    <?php if($data->price==0):?>
                        <a href="<?php echo Yii::app()->createUrl('/apps/free')?>">رایگان</a>
                    <?php else:?>
                        <a><?php echo number_format(CHtml::encode($data->price), 0).' تومان';?></a>
                    <?php endif;?>
                </span>
                <span class="app-rate">
                    <span class="icon-star"></span>
                    <span class="icon-star"></span>
                    <span class="icon-star"></span>
                    <span class="icon-star-half-empty"></span>
                    <span class="icon-star-empty"></span>
                </span>
            </div>
        </div>
    </div>
</div>