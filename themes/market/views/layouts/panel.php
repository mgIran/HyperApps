<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="keywords" content="<?= $this->keywords ?>">
    <meta name="description" content="<?= $this->description?> ">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?= $this->siteName.(!empty($this->pageTitle)?' - '.$this->pageTitle:'') ?></title>
    <link rel="shortcut icon" href="<?= Yii::app()->createAbsoluteUrl('themes/market/images/favicon.png'); ?>">
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/css/fontiran.css">
    <?php
    $baseUrl = Yii::app()->theme->baseUrl;
    $cs = Yii::app()->getClientScript();
    Yii::app()->clientScript->registerCoreScript('jquery');

    $cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
    $cs->registerCssFile($baseUrl.'/css/font-awesome.css');
    $cs->registerCssFile($baseUrl.'/css/bootstrap-theme.css');
    $cs->registerCssFile($baseUrl.'/css/animate.min.css');
    $cs->registerCssFile($baseUrl.'/css/persian-datepicker-0.4.5.min.css');
    $cs->registerCssFile($baseUrl.'/css/persian-datepicker-custom.css');
    $cs->registerCssFile($baseUrl.'/css/svg.css');
    $cs->registerCssFile($baseUrl.'/css/panel.css');
    $cs->registerCssFile($baseUrl.'/css/panel-responsive-theme.css');

    $cs->registerCoreScript('jquery.ui');
    $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js');
    $cs->registerScriptFile($baseUrl.'/js/persian-datepicker-0.4.5.min.js');
    $cs->registerScriptFile($baseUrl.'/js/persian-date.js');
    $cs->registerScriptFile($baseUrl.'/js/jquery.mousewheel.min.js');
    $cs->registerScriptFile($baseUrl.'/js/jquery.nicescroll.min.js');
    $cs->registerScriptFile($baseUrl.'/js/scripts.js');
    ?>
</head>
<body>
<?= $this->renderPartial('//layouts/_header'); ?>
<?= $this->renderPartial('//layouts/_svgDef'); ?>
<?= $this->renderPartial('//layouts/_mobile_header'); ?>
<div class="col-xs-12">
    <section class="content row">
        <div class="side-bar">
            <div class="scroll-container">
                <h5>کاربری</h5>
                <ul>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl("/dashboard?tab=credit-tab");?>">
                            <i class="icon dashboard-icon"></i>
                            <span>داشبورد</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl("/dashboard?tab=transactions-tab");?>">
                            <i class="icon transaction-icon"></i>
                            <span>تراکنش ها</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl("/dashboard?tab=buys-tab");?>">
                            <i class="icon cart-icon"></i>
                            <span>خریدها</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl("/dashboard?tab=bookmarks-tab");?>">
                            <i class="icon heart-icon"></i>
                            <span>نشان شده ها</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $this->createUrl('/tickets/manage/'); ?>">
                            <i class="icon support-icon"></i>
                            <span>پشتیبانی</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl("/dashboard?tab=setting-tab");?>">
                            <i class="icon setting-icon"></i>
                            <span>تنظیمات</span>
                        </a>
                    </li>
                </ul>
                <?php if(Yii::app()->user->roles == 'developer'):?>
                    <h5>توسعه دهندگان</h5>
                    <ul class="developers-menu">
                        <li>
                            <a href="<?php echo $this->createUrl('/developers/panel');?>">
                                <i class="icon phone-icon"></i>
                                <span>برنامه ها</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $this->createUrl('/developers/panel/discount');?>">
                                <i class="icon discount-icon"></i>
                                <span>تخفیفات</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $this->createUrl('/developers/panel/account');?>">
                                <i class="icon user-icon"></i>
                                <span>حساب توسعه دهنده</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $this->createUrl('/developers/panel/sales');?>">
                                <i class="icon chart-icon"></i>
                                <span>گزارش فروش</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $this->createUrl('/developers/panel/settlement');?>">
                                <i class="icon payment-icon"></i>
                                <span>تسویه حساب</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $this->createUrl('/tickets/manage?dev=1');?>">
                                <i class="icon support-icon"></i>
                                <span>پشتیبانی</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $this->createUrl('/developers/panel/documents');?>">
                                <i class="icon books-icon"></i>
                                <span>مستندات</span>
                            </a>
                        </li>
                    </ul>
                <?php endif;?>
            </div>
        </div>
        <div class="content-bar">
            <?php echo $content; ?>
        </div>
    </section>
</div>
<?= $this->renderPartial('//layouts/_footer'); ?>
</body>
</html>
<?php Yii::app()->clientScript->registerScript("nice-scroll",'
$(".side-bar .scroll-container").niceScroll({cursorcolor: "#ccc"});
');?>