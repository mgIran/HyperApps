<?php
/* @var $this PanelController */
/* @var $detailsModel UserDetails */
/* @var $devIdRequestModel UserDevIdRequests */
/* @var $nationalCardImage array */
/* @var $registrationCertificateImage array */
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
            <a href="<?php echo $this->createUrl('/developers/panel/sales');?>">گزارش فروش</a>
        </li>
        <li>
            <a href="<?php echo $this->createUrl('/developers/panel/settlement');?>">تسویه حساب</a>
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
            <?php $this->renderPartial('//layouts/_flashMessage'); ?>

            <?php $this->renderPartial('_update_profile_form', array(
                'model'=>$detailsModel,
                'nationalCardImage'=>$nationalCardImage,
                'registrationCertificateImage'=>$registrationCertificateImage,
            ));?>

            <?php if(empty($detailsModel->developer_id)):?>
                <?php $this->renderPartial('_change_developer_id_form', array(
                    'model'=>$devIdRequestModel,
                ));?>
            <?php else:?>
                <div class="col-md-6">
                    <h1>شناسه توسعه دهنده</h1>
                    <?php echo CHtml::label('شناسه شما: ', '');?>
                    <?php echo $detailsModel->developer_id;?>
                    <p class="desc">این شناسه دیگر قابل تغییر نیست.</p>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>