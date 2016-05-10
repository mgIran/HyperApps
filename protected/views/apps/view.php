<?php
/* @var $this AppsController */
/* @var $model Apps */
/* @var $similar CActiveDataProvider */
/* @var $bookmarked boolean */

Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/owl.carousel.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/owl.theme.default.min.css');
//Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery.mousewheel.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/owl.carousel.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery.magnific-popup.min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/magnific-popup.css');
Yii::app()->clientScript->registerScript('callImageGallery',"
    $('.images-carousel').magnificPopup({
		delegate: 'a',
		type: 'image',
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-img-mobile',
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
			tError: '<a href=\"%url%\">The image #%curr%</a> could not be loaded.',
			titleSrc: function(item) {
				return '';
			}
		}
	});
");

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
                <svg class="svg svg-bag green"><use xlink:href="#bag"></use></svg>
                <span ><?= $model->install ?>&nbsp;نصب فعال</span>
            </div>
            <div class="row-fluid">
                <svg class="svg svg-coin green"><use xlink:href="#coin"></use></svg>
                <span ><?= $model->price?number_format($model->price, 0).' تومان':'رایگان'; ?></span>
            </div>
            <div class="row-fluid">
                <span class="pull-left">
                    <button class="btn btn-success btn-install hidden-sm hidden-xs" type="button" data-toggle="modal" data-target="#install-modal">نصب</button>
                    <?php if($model->price>0):?>
                        <a class="btn btn-success btn-install hidden-md hidden-lg" href="<?php echo Yii::app()->createAbsoluteUrl('/apps/buy/'.CHtml::encode($model->id).'/'.CHtml::encode($model->title));?>">نصب</a>
                    <?php else:?>
                        <a class="btn btn-success btn-install hidden-md hidden-lg" href="<?php echo Yii::app()->createAbsoluteUrl('/apps/download/'.CHtml::encode($model->id).'/'.CHtml::encode($model->title));?>">نصب</a>
                    <?php endif;?>
                </span>
                <?php if(!Yii::app()->user->isGuest):?>
                    <span class="pull-left relative bookmark<?php echo ($bookmarked)?' bookmarked':'';?>">
                        <?= CHtml::ajaxLink('',array('/apps/bookmark'),array(
                            'data' => "js:{appId:$model->id}",
                            'type' => 'POST',
                            'dataType' => 'JSON',
                            'success' => 'js:function(data){
                                if(data.status){
                                    if($(".bookmark").hasClass("bookmarked")){
                                        $(".svg-bookmark#bookmark").html("<use xlink:href=\'#add-to-bookmark\'></use>");
                                        $(".bookmark").removeClass("bookmarked");
                                        $(".bookmark").find(".title").text("نشان کردن");
                                    }
                                    else{
                                        $(".svg-bookmark#bookmark").html("<use xlink:href=\'#bookmarked\'></use>");
                                        $(".bookmark").find(".title").text("نشان شده");
                                        $(".bookmark").addClass("bookmarked");
                                    }
                                }
                                else
                                    alert("در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید.");
                                return false;
                            }'
                        ),array(
                            'id' =>"bookmark-app"
                        )); ?>
                        <svg id="bookmark" class="svg svg-bookmark green"><use xlink:href="<?php echo ($bookmarked)?'#bookmarked':'#add-to-bookmark';?>"></use></svg>
                        <svg id="remove" class="svg svg-bookmark green"><use xlink:href="#remove-bookmark"></use></svg>
                        <script>
                            $(function(){
                                $(this).find(".svg-bookmark#remove").hide();
                                $('body').on('mouseenter','.bookmark',function(){
                                    if($(this).hasClass('bookmarked')) {
                                        $(this).find(".svg-bookmark#bookmark").hide();
                                        $(this).find(".svg-bookmark#remove").show();
                                    }
                                });
                                $('body').on('mouseleave','.bookmark',function(){
                                    $(this).find(".svg-bookmark#bookmark").show();
                                    $(this).find(".svg-bookmark#remove").hide();
                                });
                            });
                        </script>
                        <span class="green title" ><?php echo ($bookmarked)?'نشان شده':'نشان کردن';?></span>
                    </span>
                <?php endif;
                ?>
            </div>
        </div>
        <div class="app-body">
            <div class="images-carousel">
                <?
                $imager=new Imager();
                foreach($model->images as $key => $image):
                    if(file_exists(Yii::getPathOfAlias("webroot").'/uploads/apps/images/'.$image->image)):
                        $imageInfo=$imager->getImageInfo(Yii::getPathOfAlias("webroot").'/uploads/apps/images/'.$image->image);
                        $ratio=$imageInfo['width']/$imageInfo['height'];
                ?>
                        <div class="image-item" style="width: <?php echo 318*$ratio;?>px;" data-toggle="modal" data-index="<?= $key ?>" data-target="#carousesl-modal">
                            <a href="<?= Yii::app()->createAbsoluteUrl('/uploads/apps/images/'.$image->image) ?>"><img src="<?= Yii::app()->createAbsoluteUrl('/uploads/apps/images/'.$image->image) ?>" alt="<?= $model->title ?>" ></a>
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
            <?php if(!is_null($model->change_log) or $model->change_log!=''):?>
                <div class="change-log">
                    <h4>آخرین تغییرات</h4>
                    <div class="app-description">
                        <?= $model->change_log ?>
                    </div>
                </div>
            <?php endif;?>
            <div class="app-details">
                <h4>اطلاعات برنامه</h4>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 detail">
                    <h5>حجم</h5>
                    <span class="ltr" ><?= Controller::fileSize($filePath.$model->file_name) ?></span>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 detail">
                    <h5>نسخه</h5>
                    <span class="ltr" ><?= $model->version ?></span>
                </div>
            </div>
            <?php if(!is_null($model->permissions) or $model->permissions!=''):?>
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
            <?php endif;?>
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
    <div class="app-like col-sm-12 col-xs-12">
        <div class="app-box">
            <div class="top-box">
                <div class="title pull-right">
                    <h2>مشابه</h2>
                </div>
            </div>
            <div class="app-vertical">
                <?php $this->widget('zii.widgets.CListView', array(
                    'id'=>'similar-apps',
                    'dataProvider'=>$similar,
                    'itemView'=>'_vertical_app_item',
                    'template'=>'{items}',
                ));?>
            </div>
        </div>
    </div>

    <div id="install-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h3>برای دانلود برنامه کد زیر را اسکن کنید</h3>
                    <div class="qr-code-container">
                        <?php if($model->price>0):?>
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo urlencode(Yii::app()->createAbsoluteUrl('/apps/buy/'.CHtml::encode($model->id).'/'.CHtml::encode($model->title)));?>" />
                        <?php else:?>
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo urlencode(Yii::app()->createAbsoluteUrl('/apps/download/'.CHtml::encode($model->id).'/'.CHtml::encode($model->title)));?>" />
                        <?php endif;?>
                    </div>
                    <?php
                    if($model->price>0) {
                        ?>
                        <a href="<?php echo $this->createUrl('/apps/buy/'.CHtml::encode($model->id).'/'.CHtml::encode($model->title)); ?>"
                           class="btn btn-success btn-buy">خرید</a>
                        <?php
                    }else {
                        ?>
                        <a href="#"
                           data-dismiss="modal"
                           class="btn btn-default">بستن</a>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div id="carousel-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">

                </div>
            </div>
        </div>
    </div>
<?php Yii::app()->clientScript->registerScript('app-images-carousel',"
    $('.images-carousel').owlCarousel({
        autoWidth:true,
        margin:10,
        rtl:true,
        dots:false
    });
"); ?>