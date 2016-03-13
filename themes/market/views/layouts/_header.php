<? if(!Yii::app()->user->isGuest && Yii::app()->user->type == 'user'):?>
    <div id="user-menu">
        <div class="overly"></div>
        <ul class="user-menu">
            <li>
                <a href="<?= Yii::app()->createUrl('/dashboard') ?>"><span class="icon-dashboard"></span>داشبورد</a>
            </li>
            <li>
                <a href="<?= Yii::app()->createUrl('logout') ?>"><span class="icon-exit"></span>خروج</a>
            </li>
        </ul>
    </div>
<? endif;?>
<header class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="logo-box col-xs-12">
        <a href="<?= Yii::app()->createAbsoluteUrl('//'); ?>"></a>
        <h1><?= $this->siteName ?></h1>
        <h2><?= $this->pageTitle ?></h2>
        <img class="logo" src="<?= Yii::app()->createAbsoluteUrl('themes/market/images/logo.png'); ?>" alt="HyperApps" >
    </div>
    <div class="right-header col-xs-12">
        <div class="search-box col-xs-12">
            <?
            $form = $this->beginWidget('CActiveForm',array(
                'id' => 'header-serach-form',
                'action' => array('/site/search'),
                'htmlOptions' => array(
                    'class' => 'col-lg-9 col-md-9 col-sm-9 col-xs-6'
                )
            ));
            ?>
                <div class="form-group pull-left col-lg-10 col-md-10 col-sm-12 col-xs-12">
                    <?= CHtml::textField('searchText','',array('placeholder' => 'جستجو کنید ...')); ?>
                    <span class="add-in icon-search"></span>
                </div>
            <?
            $this->endWidget();
            ?>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                <?
                if(!Yii::app()->user->isGuest && Yii::app()->user->type == 'user'){
                    ?>
                    <div class="user-section" data-toggle="dropdown" data-target="#user-menu">
                        <div class="avatar">
                            <span class="icon icon-user"></span>
                        </div>
                        <div class="user-detail">
                            <span class="name"><?= Yii::app()->user->email ?></span>
                            <span class="type"><?= Yii::app()->user->type ?></span>
                        </div>
                    </div>
                    <?
                    Yii::app()->clientScript->registerScript('userSection' ,"$('body').on('click','.user-section',function(){
                                if($(this).attr('aria-expanded') != true)
                                    $('body,html').css({'overflow':'hidden','padding-right':'9px'});
                            });
                            $('body').on('click',function(event){
                                if(event.target.className == 'overly')
                                    $('body,html').css({'overflow-y':'visible','padding-right':'0'});
                            });
                            ");
                }
                else{
                    ?>
                    <div class="header-links pull-left">
                        <a href="<?= Yii::app()->createUrl('/login') ?>">
                            ورود
                        </a>
                        <a href="<?= Yii::app()->createUrl('/register') ?>">
                            ثبت نام
                        </a>
                    </div>
                <?
                }
                ?>
            </div>
        </div>
    </div>
</header>