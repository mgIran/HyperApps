<?
/* @var $this SiteController */
/* @var $newestProgramDataProvider CActiveDataProvider */
/* @var $newestGameDataProvider CActiveDataProvider */

Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/owl.carousel.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery.mousewheel.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/owl.carousel.min.js');

Yii::app()->clientScript->registerScript('updateListView',"
    $('.sidebar a').click(function(){
        var p=$(this).data('platform');
        $.fn.yiiListView.update('newest-programs',{
            data:{platform:p},
            complete:function(){
                var owl = $('.app-carousel');
                owl.owlCarousel({
                    responsive:{
                        0:{
                            items : 1,
                        },
                        410:{
                            items : 2,
                        },
                        580:{
                            items : 3
                        },
                        800:{
                            items : 4
                        },
                        992:{
                            items : 5
                        },
                        1370:{
                            items : 6
                        }
                    },
                    lazyLoad :true,
                    margin :0,
                    rtl:true,
                    nav:true,
                    navText : ['','<span class=\"icon-chevron-left\"></span>']
                });
            }
        });
        return false;
    });
");
?>

    <div class="app-box">
        <div class="top-box">
            <div class="title pull-right">
                <h2 >جدیدترین برنامه ها</h2>
            </div>
            <a class="pull-left btn btn-success more-app" href="<?php echo $this->createUrl('/apps/programs');?>">بیشتر</a>
        </div>
        <?php $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$newestProgramDataProvider,
            'id'=>'newest-programs',
            'itemView'=>'_app_item',
            'template'=>'{items}',
            'itemsCssClass'=>'app-carousel'
        ));?>
    </div>
    <div class="app-box">
        <div class="top-box">
            <div class="title pull-right">
                <h2 >جدیدترین بازی ها</h2>
            </div>
            <a class="pull-left btn btn-success more-app" href="<?php echo $this->createUrl('/apps/games');?>">بیشتر</a>
        </div>
        <?php $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$newestGameDataProvider,
            'itemView'=>'_app_item',
            'template'=>'{items}',
            'itemsCssClass'=>'app-carousel'
        ));?>
    </div>
    <div class="banner-box">
        <div class="banner-carousel">
            <div class="banner-item">
                <div class="fade-overly"></div>
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
                <img src="<?= Yii::app()->theme->baseUrl; ?>/images/login-back.png">
            </div>
        </div>
    </div>
    <div class="app-box">
        <div class="top-box">
            <div class="title pull-right">
                <h2 >برترین ها</h2>
            </div>
            <button type="button" class="pull-left btn btn-success more-app" >
                بیشتر
            </button>
        </div>
        <div class="app-carousel">
            <div class="app-item">
                <div class="app-item-content">
                    <div class="pic">
                        <div>
                            <img src="<?= Yii::app()->theme->baseUrl; ?>/images/login-back.png">
                        </div>
                    </div>
                    <div class="detail">
                        <div class="app-title">
                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس
                            <span class="paragraph-end"></span>
                        </div>
                        <div class="app-any">
                                    <span class="app-price">
                                        رایگان
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
            <div class="app-item">
                <div class="app-item-content">
                    <div class="pic">
                        <div>
                            <img src="<?= Yii::app()->theme->baseUrl; ?>/images/login-back.png">
                        </div>
                    </div>
                    <div class="detail">
                        <div class="app-title">
                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس
                            <span class="paragraph-end"></span>
                        </div>
                        <div class="app-any">
                                    <span class="app-price">
                                        رایگان
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
            <div class="app-item">
                <div class="app-item-content">
                    <div class="pic">
                        <div>
                            <img src="<?= Yii::app()->theme->baseUrl; ?>/images/login-back.png">
                        </div>
                    </div>
                    <div class="detail">
                        <div class="app-title">
                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس
                            <span class="paragraph-end"></span>
                        </div>
                        <div class="app-any">
                                    <span class="app-price">
                                        رایگان
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
            <div class="app-item">
                <div class="app-item-content">
                    <div class="pic">
                        <div>
                            <img src="<?= Yii::app()->theme->baseUrl; ?>/images/login-back.png">
                        </div>
                    </div>
                    <div class="detail">
                        <div class="app-title">
                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس
                            <span class="paragraph-end"></span>
                        </div>
                        <div class="app-any">
                                    <span class="app-price">
                                        رایگان
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
            <div class="app-item">
                <div class="app-item-content">
                    <div class="pic">
                        <div>
                            <img src="<?= Yii::app()->theme->baseUrl; ?>/images/login-back.png">
                        </div>
                    </div>
                    <div class="detail">
                        <div class="app-title">
                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس
                            <span class="paragraph-end"></span>
                        </div>
                        <div class="app-any">
                                    <span class="app-price">
                                        رایگان
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
        </div>
    </div>
    <div class="app-box">
        <div class="top-box">
            <div class="title pull-right">
                <h2 >پر فروش های هفته</h2>
            </div>
            <button type="button" class="pull-left btn btn-success more-app" >
                بیشتر
            </button>
        </div>
        <div class="app-carousel">
            <div class="app-item">
                <div class="app-item-content">
                    <div class="pic">
                        <div>
                            <img src="<?= Yii::app()->theme->baseUrl; ?>/images/login-back.png">
                        </div>
                    </div>
                    <div class="detail">
                        <div class="app-title">
                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس
                            <span class="paragraph-end"></span>
                        </div>
                        <div class="app-any">
                                    <span class="app-price">
                                        رایگان
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
            <div class="app-item">
                <div class="app-item-content">
                    <div class="pic">
                        <div>
                            <img src="<?= Yii::app()->theme->baseUrl; ?>/images/login-back.png">
                        </div>
                    </div>
                    <div class="detail">
                        <div class="app-title">
                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس
                            <span class="paragraph-end"></span>
                        </div>
                        <div class="app-any">
                                    <span class="app-price">
                                        رایگان
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
            <div class="app-item">
                <div class="app-item-content">
                    <div class="pic">
                        <div>
                            <img src="<?= Yii::app()->theme->baseUrl; ?>/images/login-back.png">
                        </div>
                    </div>
                    <div class="detail">
                        <div class="app-title">
                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس
                            <span class="paragraph-end"></span>
                        </div>
                        <div class="app-any">
                                    <span class="app-price">
                                        رایگان
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
            <div class="app-item">
                <div class="app-item-content">
                    <div class="pic">
                        <div>
                            <img src="<?= Yii::app()->theme->baseUrl; ?>/images/login-back.png">
                        </div>
                    </div>
                    <div class="detail">
                        <div class="app-title">
                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس
                            <span class="paragraph-end"></span>
                        </div>
                        <div class="app-any">
                                    <span class="app-price">
                                        رایگان
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
            <div class="app-item">
                <div class="app-item-content">
                    <div class="pic">
                        <div>
                            <img src="<?= Yii::app()->theme->baseUrl; ?>/images/login-back.png">
                        </div>
                    </div>
                    <div class="detail">
                        <div class="app-title">
                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس
                            <span class="paragraph-end"></span>
                        </div>
                        <div class="app-any">
                                    <span class="app-price">
                                        رایگان
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
        </div>
    </div>
    <div class="app-box">
        <div class="top-box">
            <div class="title pull-right">
                <h2 >تازه های آموزشی</h2>
            </div>
            <button type="button" class="pull-left btn btn-success more-app" >
                بیشتر
            </button>
        </div>
        <div class="app-carousel">
            <div class="app-item">
                <div class="app-item-content">
                    <div class="pic">
                        <div>
                            <img src="<?= Yii::app()->theme->baseUrl; ?>/images/login-back.png">
                        </div>
                    </div>
                    <div class="detail">
                        <div class="app-title">
                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس
                            <span class="paragraph-end"></span>
                        </div>
                        <div class="app-any">
                                    <span class="app-price">
                                        رایگان
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
            <div class="app-item">
                <div class="app-item-content">
                    <div class="pic">
                        <div>
                            <img src="<?= Yii::app()->theme->baseUrl; ?>/images/login-back.png">
                        </div>
                    </div>
                    <div class="detail">
                        <div class="app-title">
                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس
                            <span class="paragraph-end"></span>
                        </div>
                        <div class="app-any">
                                    <span class="app-price">
                                        رایگان
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
            <div class="app-item">
                <div class="app-item-content">
                    <div class="pic">
                        <div>
                            <img src="<?= Yii::app()->theme->baseUrl; ?>/images/login-back.png">
                        </div>
                    </div>
                    <div class="detail">
                        <div class="app-title">
                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس
                            <span class="paragraph-end"></span>
                        </div>
                        <div class="app-any">
                                    <span class="app-price">
                                        رایگان
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
            <div class="app-item">
                <div class="app-item-content">
                    <div class="pic">
                        <div>
                            <img src="<?= Yii::app()->theme->baseUrl; ?>/images/login-back.png">
                        </div>
                    </div>
                    <div class="detail">
                        <div class="app-title">
                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس
                            <span class="paragraph-end"></span>
                        </div>
                        <div class="app-any">
                                    <span class="app-price">
                                        رایگان
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
            <div class="app-item">
                <div class="app-item-content">
                    <div class="pic">
                        <div>
                            <img src="<?= Yii::app()->theme->baseUrl; ?>/images/login-back.png">
                        </div>
                    </div>
                    <div class="detail">
                        <div class="app-title">
                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس
                            <span class="paragraph-end"></span>
                        </div>
                        <div class="app-any">
                                    <span class="app-price">
                                        رایگان
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
        </div>
    </div>
<?
Yii::app()->clientScript->registerScript('carousels','
    var owl = $(".app-carousel");
    owl.owlCarousel({
        responsive:{
            0:{
                items : 1,
            },
            410:{
                items : 2,
            },
            580:{
                items : 3
            },
            800:{
                items : 4
            },
            992:{
                items : 5
            },
            1370:{
                items : 6
            }
        },
        lazyLoad :true,
        margin :0,
        rtl:true,
        nav:true,
        navText : ["","<span class=\'icon-chevron-left\'></span>"]
    });

'
);