<?php
/* @var $this PanelController */
/* @var $detailsModel UserDetails */
/* @var $devIdRequestModel UserDevIdRequests */
?>

<div class="container">
    <ul class="nav nav-tabs">
        <li>
            <a href="<?php echo $this->createUrl('/developers/panel');?>">برنامه ها</a>
        </li>
        <li class="active">
            <a href="<?php echo $this->createUrl('/developers/panel/account');?>">حساب توسعه دهنده</a>
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

    <div class="tab-content card-container">
        <div class="tab-pane active">
            <?php if(Yii::app()->user->hasFlash('success')):?>
                <div class="alert alert-success fade in">
                    <button class="close close-sm" type="button" data-dismiss="alert"><i class="icon-remove"></i></button>
                    <?php echo Yii::app()->user->getFlash('success');?>
                </div>
            <?php elseif(Yii::app()->user->hasFlash('fail')):?>
                <div class="alert alert-danger fade in">
                    <button class="close close-sm" type="button" data-dismiss="alert"><i class="icon-remove"></i></button>
                    <?php echo Yii::app()->user->getFlash('fail');?>
                </div>
            <?php endif;?>

            <h1>مشخصات</h1>
            <?php $this->renderPartial('_update_profile_form', array(
                'model'=>$detailsModel,
            ));?>

            <h1>شناسه توسعه دهنده</h1>
            <?php $this->renderPartial('_change_developer_id_form', array(
                'model'=>$devIdRequestModel,
            ));?>
        </div>
    </div>
</div>