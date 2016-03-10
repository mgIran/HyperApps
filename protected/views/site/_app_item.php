<?php
/* @var $data Apps */
?>

<div class="app-item">
    <div class="app-item-content">
        <div class="pic">
            <div>
                <img src="<?php echo Yii::app()->baseUrl.'/uploads/apps/icons/'.CHtml::encode($data->icon);?>">
            </div>
        </div>
        <div class="detail">
            <div class="app-title">
                <a href="<?php echo Yii::app()->createUrl('/apps/'.$data->id.'/'.urlencode($data->title));?>">
                    <?php echo CHtml::encode($data->title);?>
                    <span class="paragraph-end"></span>
                </a>
            </div>
            <div class="app-any">
                <span class="app-price">
                    <a href="<?php echo Yii::app()->createUrl('/apps/free')?>">رایگان</a>
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