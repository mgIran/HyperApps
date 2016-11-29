<?php
/* @var $this PanelController */
/* @var $detailsModel UserDetails */
/* @var $devIdRequestModel UserDevIdRequests */
/* @var $nationalCardImage array */
/* @var $registrationCertificateImage array */
?>

<div class="container">
    <? $this->renderPartial('_tab_links',array('active' => $this->action->id)); ?>

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
                    <h1 style="margin-top: 70px;">امتیاز</h1>
                    <?php echo CHtml::label('امتیاز شما:', '');?>
                    <?php echo $detailsModel->dev_score;?>
                    <p class="desc">به ازای فروش هر برنامه یک امتیاز در نظر گرفته می شود.</p>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>