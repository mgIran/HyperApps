<?php
/* @var $this AppsController */
/* @var $model Apps */

Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/owl.carousel.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery.mousewheel.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/owl.carousel.min.js');

if($model->platform)
{
    $platform = $model->platform;
    $filesFolder = $platform->name;
    $filePath = Yii::getPathOfAlias("webroot")."/uploads/apps/files/{$filesFolder}/";
}
?>

<div class="app col-sm-12 col-xs-12">
    <div class="app-inner">
        <div class="pic">
            <img src="<?= Yii::app()->createUrl('/uploads/apps/icons/'.$model->icon);?>" alt="<?= $model->title ?>">
        </div>
        <div class="app-heading">
            <h2><?= $model->title ?></h2>
            <div class="row-fluid">
                <span ><?= $model->developer?$model->developer->userDetails->fa_name:$model->developer_team; ?></span>
                <span ><?= $model->category?$model->category->title:''; ?></span>
                <span class="app-rate">
                    <? ?>
                </span>
            </div>
            <div class="row-fluid">
                <span class="svg svg-bag green" ></span>
                <span ><?= $model->install ?>&nbsp;نصب فعال</span>
            </div>
            <div class="row-fluid">
                <span class="svg svg-coin green" ></span>
                <span ><?= $model->price?$model->price:'رایگان'; ?></span>
            </div>
            <div class="row-fluid">
                <span class="pull-left">
                    <button class="btn btn-success" type="button" >نصب</button>
                </span>
                <span class="pull-left relative">
                    <?= CHtml::ajaxLink('',array('/apps/bookmark'),array(
                        'data' => "js:{appId:$model->id}",
                        'type' => 'POST',
                        'dataType' => 'json',
                        'success' => 'js:function(data){
                            console.log(data);
                        }'
                    ),array(
                        'id' =>"bookmark-app"
                    )); ?>
                    <span class="svg svg-bookmark green" ></span>
                    <span class="green" >نشان کردن</span>
                </span>
            </div>
        </div>
        <div class="app-body">
            <div class="images-carousel">
                <?
                foreach($model->images as $image):
                    if(file_exists(Yii::getPathOfAlias("webroot").'/uploads/apps/images/'.$image->image)):
                ?>
                        <div class="image-item">
                            <img src="<?= Yii::app()->createAbsoluteUrl('/uploads/apps/images/'.$image->image) ?>" alt="<?= $model->title ?>" >
                        </div>
                <?
                    endif;
                endforeach;
                ?>
            </div>
            <section>
                <div class="app-description">
                    <?= $model->description ?>
                </div>
                <a class="more-text" href="#">
                    <span>توضیحات بیشتر</span>
                </a>
            </section>
            <div class="change-log">
                <h4>آخرین تغییرات</h4>
                <div class="app-description">
                    <?= $model->change_log ?>
                </div>
            </div>
            <div class="app-details">
                <h4>اطلاعات برنامه</h4>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 detail">
                    <h5>حجم</h5>
                    <span class="ltr" ><?= Controller::fileSize($filePath.$model->file_name) ?></span>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 detail">
                    <h5>نسخه</h5>
                    <span class="ltr" ><?= $model->version ?></span>
                </div>
            </div>
            <div class="app-details border-none">
                <?
                if($model->permissions):
                    echo '<h4>دسترسی ها</h4>';
                    echo '<ul class="list-unstyled">';
                    $model->permissions = CJSON::decode($model->permissions);
                    foreach($model->permissions as $permission):
                        echo "<li>- {$permission}</li>";
                    endforeach;
                    echo '</ul>';
                endif;
                ?>
            </div>
            <!--<div class="app-comments">
                <h4 class="pull-right">نظر کاربران</h4>
                    <button class="btn btn-default pull-left">
                        <span class="icon-pencil">  </span>
                        نظرتان را بگویید
                    </button>
            </div>-->
        </div>
    </div>
</div>
    <div class=" app-like col-sm-12 col-xs-12">
        <div class="app-box">
            <div class="top-box">
                <div class="title pull-right">
                    <h2 >برترین ها</h2>
                </div>
                <button type="button" class="pull-left btn btn-success more-app" >
                    بیشتر
                </button>
            </div>
            <div class="app-vertical">
                <div class="app-details">
                    <div class="pic">
                        <img src="<?= Yii::app()->theme->baseUrl; ?>/images/login-back.png">
                    </div>
                    <div class="app-content">
                        <div class="title">
                            <a href="#">
                                خشم سرعت
                            </a>
                        </div>
                        <div class="title" >
                                    <span class="text-right green col-lg-6 col-md-6 col-sm-6 col-xs-6" >
                                        رایگان
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
                            جـاده هـای ایـران شـما را بـه
                            چـالـشی تـازه فـرا می خوانند؛
                            رانـنـده خـود را انتـخاب کنید،
                            از یـک رانـنـده تـاکـسی عـادی
                            گرفته تا قـهرمـان مـسابـقاتید،
                            از یـک رانـنـده تـاکـسی عـادی
                            گرفته تا قـهرمـان مـسابـقاتید،
                            از یـک رانـنـده تـاکـسی عـادی
                            گرفته تا قـهرمـان مـسابـقات
                            <span class="paragraph-end"></span>
                        </div>
                    </div>
                    <div class="app-footer">
                                <span class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
                                    20,0000+ دانلود
                                </span>
                                <span class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
                                    3.7 مگابایت
                                </span>
                                <span class="col-lg-4 col-md-4 col-sm-4 hidden-xs green">
                                    گروه پولاد
                                </span>
                    </div>
                </div>
                <div class="app-details">
                    <div class="pic">
                        <img src="<?= Yii::app()->theme->baseUrl; ?>/images/login-back.png">
                    </div>
                    <div class="app-content">
                        <div class="title">
                            <a href="#">
                                خشم سرعت
                            </a>
                        </div>
                        <div class="title" >
                                    <span class="text-right green col-lg-6 col-md-6 col-sm-6 col-xs-6" >
                                        رایگان
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
                            جـاده هـای ایـران شـما را بـه
                            چـالـشی تـازه فـرا می خوانند؛
                            رانـنـده خـود را انتـخاب کنید،
                            از یـک رانـنـده تـاکـسی عـادی
                            گرفته تا قـهرمـان مـسابـقاتید،
                            از یـک رانـنـده تـاکـسی عـادی
                            گرفته تا قـهرمـان مـسابـقاتید،
                            از یـک رانـنـده تـاکـسی عـادی
                            گرفته تا قـهرمـان مـسابـقات
                            <span class="paragraph-end"></span>
                        </div>
                    </div>
                    <div class="app-footer">
                                <span class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
                                    20,0000+ دانلود
                                </span>
                                <span class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
                                    3.7 مگابایت
                                </span>
                                <span class="col-lg-4 col-md-4 col-sm-4 hidden-xs green">
                                    گروه پولاد
                                </span>
                    </div>
                </div>
                <div class="app-details">
                    <div class="pic">
                        <img src="<?= Yii::app()->theme->baseUrl; ?>/images/login-back.png">
                    </div>
                    <div class="app-content">
                        <div class="title">
                            <a href="#">
                                خشم سرعت
                            </a>
                        </div>
                        <div class="title" >
                                    <span class="text-right green col-lg-6 col-md-6 col-sm-6 col-xs-6" >
                                        رایگان
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
                            جـاده هـای ایـران شـما را بـه
                            چـالـشی تـازه فـرا می خوانند؛
                            رانـنـده خـود را انتـخاب کنید،
                            از یـک رانـنـده تـاکـسی عـادی
                            گرفته تا قـهرمـان مـسابـقاتید،
                            از یـک رانـنـده تـاکـسی عـادی
                            گرفته تا قـهرمـان مـسابـقاتید،
                            از یـک رانـنـده تـاکـسی عـادی
                            گرفته تا قـهرمـان مـسابـقات
                            <span class="paragraph-end"></span>
                        </div>
                    </div>
                    <div class="app-footer">
                                <span class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
                                    20,0000+ دانلود
                                </span>
                                <span class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
                                    3.7 مگابایت
                                </span>
                                <span class="col-lg-4 col-md-4 col-sm-4 hidden-xs green">
                                    گروه پولاد
                                </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?
//if(count($model->images)>3){
    Yii::app()->clientScript->registerScript('app-images-carousel',"
        $('.images-carousel').owlCarousel({
            dots:true,
            nav:false,
            items:3,
            rtl:false,
            //autoWidth:true,
            margin:10,
        });
    ");