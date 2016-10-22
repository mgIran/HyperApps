<?php
$purifier=new CHtmlPurifier();
/* @var $this PagesManageController*/
/* @var $model Pages */
?>
<div class="container dashboard-container">

    <? $this->renderPartial('developers.views.panel._tab_links',array('active' => 'documents')); ?>

    <a class="btn btn-success developer-signup-link" href="<?php echo Yii::app()->createUrl('/dashboard')?>">پنل کاربری</a>
    <div class="tab-content card-container">
        <p class="text-left"><a href="<?php echo $this->createUrl('/developers/panel/documents');?>" class="btn btn-info">بازگشت</a></p>
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= $model->title ?>
            </div>
            <div class="panel-body">
                <p><?= $purifier->purify($model->summary) ?></p>
            </div>
        </div>
        <p class="text-left"><a href="<?php echo $this->createUrl('/developers/panel/documents');?>" class="btn btn-info">بازگشت</a></p>
    </div>
</div>