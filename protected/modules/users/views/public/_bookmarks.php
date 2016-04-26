<?php
/* @var $this PublicController */
/* @var $model Users */
?>

<div class="container-fluid">
    <?php if(empty($model->bookmarkedApps)):?>
        نتیجه ای یافت نشد.
    <?php else:?>
        <?php foreach($model->bookmarkedApps as $app):?>
            <div class="col-md-4 bookmarked-app">
                <a href="<?php echo $this->createUrl('/apps/'.$app->id.'/'.urlencode(CHtml::encode($app->title)));?>"></a>
                <div class="col-md-5 image">
                    <img src="<?php echo Yii::app()->baseUrl.'/uploads/apps/icons/'.CHtml::encode($app->icon);?>">
                </div>
                <div class="col-md-7 info">
                    <h5><?php echo CHtml::encode($app->title);?></h5>
                    <p class="small"><?php echo (is_null($app->developer_id))?$app->developer_team:$app->developer->userDetails->fa_name;?></p>
                    <p class="small"><?php echo ($app->price==0)?'رایگان':number_format($app->price, 0).' تومان';?></p>
                </div>
            </div>
        <?php endforeach;?>
    <?php endif;?>
</div>
