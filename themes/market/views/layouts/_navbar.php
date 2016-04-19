<?php
/* @var $category AppCategories */
?>
<nav class="navbar navbar-default col-xs-12">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">
            <span class="icon-download-alt"></span>
            هایپر اپس را دانلود کنید
        </a>
    </div>

    <div class="collapse navbar-collapse" id="navbar-collapse">
        <ul class="nav navbar-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">دسته ها&nbsp;&nbsp;<span class="icon-chevron-down"></span></a>
                <div class="panel panel-body dropdown-menu cat-menu-container">
                    <div class="col-md-4">
                        <div class="row">
                            <a href="<?php echo Yii::app()->createUrl('/apps/programs');?>" class="cat-menu-head">برنامه ها</a>
                            <ul class="cat-menu">
                                <?php foreach($this->categories['programs'] as $category):?>
                                    <li><a href="<?php echo Yii::app()->createUrl('/apps/programs/'.$category->id.'/'.urlencode($category->title));?>"><?php echo $category->title;?></a></li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <a href="<?php echo Yii::app()->createUrl('/apps/games');?>" class="cat-menu-head">بازی ها</a>
                            <ul class="cat-menu">
                                <?php foreach($this->categories['games'] as $category):?>
                                    <li><a href="<?php echo Yii::app()->createUrl('/apps/games/'.$category->id.'/'.urlencode($category->title));?>"><?php echo $category->title;?></a></li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <a href="<?php echo Yii::app()->createUrl('/apps/educations');?>" class="cat-menu-head">آموزش ها</a>
                            <ul class="cat-menu">
                                <?php foreach($this->categories['educations'] as $category):?>
                                    <li><a href="<?php echo Yii::app()->createUrl('/apps/educations/'.$category->id.'/'.urlencode($category->title));?>"><?php echo $category->title;?></a></li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            <li class="divider">
                <a>|</a>
            </li>
            <li><a href="<?= Yii::app()->createAbsoluteUrl('//') ?>">خانه</a></li>
            <li><a href="#">تخفیفات</a></li>
        </ul>
    </div>
</nav>