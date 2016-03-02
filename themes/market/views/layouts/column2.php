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
    <?php
    $baseUrl = Yii::app()->theme->baseUrl;
    $cs = Yii::app()->getClientScript();
    Yii::app()->clientScript->registerCoreScript('jquery');
    ?>
    <!-- Fav and Touch and touch icons -->
    <link rel="shortcut icon" href="<?php echo $baseUrl;?>/images/favicon.ico">
    <?php
    $cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
    $cs->registerCssFile($baseUrl.'/css/bootstrap-theme.css');
    $cs->registerCssFile($baseUrl.'/css/font-awesome.css');

    $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js');
    $cs->registerScriptFile($baseUrl.'/js/jquery.cookie.js');
    $cs->registerScriptFile($baseUrl.'/js/scripts.js');
    ?>
</head>
<body>
<?= $this->renderPartial('//layouts/_header'); ?>
<div class="container-fluid body">
    <section class="sidebar-box pull-left col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="btn-group col-lg-11 col-md-11 col-sm-12 col-xs-12 pull-left">
                <button class="btn btn-advertise" onclick="window.location='<?= Yii::app()->createUrl('/advertises/add'); ?>';">
                    ارسال آگهی رایگان
                </button>
                <button class="btn btn-advertise-plus" onclick="window.location='<?= Yii::app()->createUrl('/advertises/add'); ?>';">
                    <span class="glyphicon glyphicon-plus"></span>
                </button>
            </div>
        <?
        if($this->sideRender)
            foreach($this->sideRender as $render)
            {
                if(is_string($render))
                    $this->renderPartial($render);
                elseif(is_array($render) && !empty($render['view'])){
                    $render['params'] = is_array($render['params'])?$render['params']:array();
                    $this->renderPartial($render['view'] ,$render['params']);
                }
            }
        else
            $this->renderPartial('//layouts/_sidebar');
        ?>
    </section>
    <section class="main-entry col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="breadcrumb ">
            <?php if(isset($this->breadcrumbs)):?>
                <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                    'links'=>$this->breadcrumbs,
                    'homeLink'=>false,
                    'htmlOptions'=>array('class'=>'breadcrumb-nav')
                )); ?><!-- breadcrumbs -->
            <?php endif?>
        </div>
        <?php echo $content; ?>
    </section>
</div>
<?= $this->renderPartial('//layouts/_footer'); ?>
</body>
</html>
