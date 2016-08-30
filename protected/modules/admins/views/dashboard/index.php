<?php
/* @var $this DashboardController*/
/* @var $devIDRequests CActiveDataProvider*/
/* @var $newestPrograms CActiveDataProvider*/
/* @var $newestDevelopers CActiveDataProvider*/
/* @var $newestPackages CActiveDataProvider*/
/* @var $tickets []*/
?>
<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success fade in">
        <button class="close close-sm" type="button" data-dismiss="alert"><i class="icon-remove"></i></button>
        <?php echo Yii::app()->user->getFlash('success');?>
    </div>
<?php elseif(Yii::app()->user->hasFlash('failed')):?>
    <div class="alert alert-danger fade in">
        <button class="close close-sm" type="button" data-dismiss="alert"><i class="icon-remove"></i></button>
        <?php echo Yii::app()->user->getFlash('failed');?>
    </div>
<?php endif;?>
<?
if(Yii::app()->user->roles == 'admin'):
?>
<div class="row">
    <div class="panel panel-default col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="panel-heading">
            جدیدترین نرم افزار ها
        </div>
        <div class="panel-body">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'newest-apps-grid',
                'dataProvider'=>$newestPrograms,
                'columns'=>array(
                    'title',
                    'developer_id'=>array(
                        'name'=>'developer_id',
                        'value'=>'(is_null($data->developer_id) or empty($data->developer_id))?$data->developer_team:$data->developer->userDetails->developer_id'
                    ),
                    'confirm'=>array(
                        'name'=>'confirm',
                        'value'=>'CHtml::dropDownList("confirm", "pending", $data->confirmLabels, array("class"=>"change-confirm", "data-id"=>$data->id))',
                        'type'=>'raw'
                    ),
                    array(
                        'class'=>'CButtonColumn',
                        'template' => '{view}{delete}{download}',
                        'buttons'=>array(
                            'view'=>array(
                                'label'=>'مشاهده برنامه',
                                'url'=>'Yii::app()->createUrl("/apps/".$data->id."/".urlencode($data->title))',
                                'options'=>array(
                                    'target'=>'_blank'
                                ),
                            ),
                            'delete'=>array(
                                'url'=>'CHtml::normalizeUrl(array(\'/manageApps/\'.$data->platformsID[$data->platform_id].\'/delete/\'.$data->id))'
                            ),
                            'download'=>array(
                                'label'=>'دانلود',
                                'url'=>'Yii::app()->createUrl("/manageApps/android/download/".$data->id)',
                                'imageUrl'=>Yii::app()->theme->baseUrl.'/img/download.png',
                            ),
                        ),
                    ),
                ),
            ));?>
            <?php Yii::app()->clientScript->registerScript('changeConfirm', "
                $('.change-confirm').on('change', function(){
                    $.ajax({
                        url:'".$this->createUrl('/manageApps/android/changeConfirm')."',
                        type:'POST',
                        dataType:'JSON',
                        data:{app_id:$(this).data('id'), value:$(this).val()},
                        success:function(data){
                            if(data.status){
                                $.fn.yiiGridView.update('newest-apps-grid');
                                $.fn.yiiGridView.update('newest-packages-grid');
                            }else
                                alert('در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید.');
                        }
                    });
                });
            ");?>
        </div>
    </div>
    <div class="panel panel-default col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="panel-heading">بسته های جدید</div>
        <div class="panel-body">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'newest-packages-grid',
                'dataProvider'=>$newestPackages,
                'columns'=>array(
                    'app_id'=>array(
                        'name'=>'app_id',
                        'value'=>'CHtml::link($data->app->title, Yii::app()->createUrl("/apps/".$data->app_id."/".$data->app->title))',
                        'type'=>'raw'
                    ),
                    'for'=>array(
                        'name'=>'for',
                        'value'=>'$data->forLabels[$data->for]',
                        'type'=>'raw'
                    ),
                    'version',
                    'package_name',
                    'status'=>array(
                        'name'=>'status',
                        'value'=>'CHtml::dropDownList("confirm", "pending", $data->statusLabels, array("class"=>"change-package-status", "data-id"=>$data->id))',
                        'type'=>'raw'
                    ),
                    array(
                        'class'=>'CButtonColumn',
                        'template' => '{delete}{download}',
                        'buttons'=>array(
                            'delete'=>array(
                                'url'=>'Yii::app()->createUrl("/manageApps/android/deletePackage/".$data->id)',
                            ),
                            'download'=>array(
                                'label'=>'دانلود',
                                'url'=>'Yii::app()->createUrl("/manageApps/android/downloadPackage/".$data->id)',
                                'imageUrl'=>Yii::app()->theme->baseUrl.'/img/download.png',
                            ),
                        ),
                    ),
                ),
            ));?>
            <?php Yii::app()->clientScript->registerScript('changePackageStatus', "
                $('body').on('change', '.change-package-status', function(){
                    if($(this).val()=='refused' || $(this).val()=='change_required'){
                        $('#reason-modal').modal('show');
                        $('input#package-id').val($(this).data('id'));
                        $('input#package-status').val($(this).val());
                    }else{
                        $.ajax({
                            url:'".$this->createUrl('/manageApps/android/changePackageStatus')."',
                            type:'POST',
                            dataType:'JSON',
                            data:{package_id:$(this).data('id'), value:$(this).val()},
                            success:function(data){
                                if(data.status)
                                    $.fn.yiiGridView.update('newest-packages-grid');
                                else
                                    alert('در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید.');
                            }
                        });
                    }
                });
                $('.close-reason-modal').click(function(){
                    $.fn.yiiGridView.update('newest-packages-grid');
                    $('#reason-text').val('');
                });
                $('.save-reason-modal').click(function(){
                    if($('#reason-text').val()==''){
                        $('.reason-modal-message').addClass('error').text('لطفا دلیل را ذکر کنید.');
                        return false;
                    }else{
                        $('.reason-modal-message').removeClass('error').text('در حال ثبت...');
                        $.ajax({
                            url:'".$this->createUrl('/manageApps/android/changePackageStatus')."',
                            type:'POST',
                            dataType:'JSON',
                            data:{package_id:$('#package-id').val(), value:$('#package-status').val(), reason:$('#reason-text').val()},
                            success:function(data){
                                if(data.status){
                                    $.fn.yiiGridView.update('newest-packages-grid');
                                    $('#reason-modal').modal('hide');
                                    $('#reason-text').val('');
                                    $('.reason-modal-message').text('');
                                } else
                                    alert('در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید.');
                            }
                        });
                    }
                });
            ");?>
        </div>
    </div>
</div>
<div class="row">
    <div class="panel panel-default col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="panel-heading">
            درخواست های تغییر شناسه توسعه دهنده
        </div>
        <div class="panel-body">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'dev-id-requests-grid',
                'dataProvider'=>$devIDRequests,
                'columns'=>array(
                    'user_id'=>array(
                        'name'=>'user_id',
                        'value'=>'CHtml::link($data->user->userDetails->fa_name, Yii::app()->createUrl("/users/".$data->user->id))',
                        'type'=>'raw'
                    ),
                    'requested_id',
                    array(
                        'class'=>'CButtonColumn',
                        'template' => '{confirm}{delete}',
                        'buttons'=>array(
                            'confirm'=>array(
                                'label'=>'تایید کردن',
                                'url'=>"CHtml::normalizeUrl(array('/users/usersManage/confirmDevID', 'id'=>\$data->user_id))",
                                'imageUrl'=>Yii::app()->theme->baseUrl.'/img/confirm.png',
                            ),
                            'delete'=>array(
                                'url'=>'CHtml::normalizeUrl(array(\'/users/usersManage/deleteDevID\', \'id\'=>$data->user_id))'
                            ),
                        ),
                    ),
                ),
            ));?>
        </div>
    </div>
    <div class="panel panel-default col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="panel-heading">
            اطلاعات توسعه دهندگان جدید<small>(تایید نشده)</small>
        </div>
        <div class="panel-body">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'newest-developers-grid',
                'dataProvider'=>$newestDevelopers,
                'columns'=>array(
                    'email'=>array(
                        'name'=>'email',
                        'value'=>'CHtml::link($data->user->email, Yii::app()->createUrl("/users/".$data->user_id))',
                        'type'=>'raw'
                    ),
                    'fa_name',
                    array(
                        'class'=>'CButtonColumn',
                        'template' => '{view}{confirm}{refused}',
                        'buttons'=>array(
                            'confirm'=>array(
                                'label'=>'تایید کردن',
                                'url'=>"CHtml::normalizeUrl(array('/users/usersManage/confirmDeveloper', 'id'=>\$data->user_id))",
                                'imageUrl'=>Yii::app()->theme->baseUrl.'/img/confirm.png',
                            ),
                            'refused'=>array(
                                'label'=>'رد کردن',
                                'url'=>'CHtml::normalizeUrl(array(\'/users/usersManage/refuseDeveloper\', \'id\'=>$data->user_id))',
                                'imageUrl'=>Yii::app()->theme->baseUrl.'/img/refused.png',
                            ),
                            'view'=>array(
                                'url'=>'CHtml::normalizeUrl(array("/users/".$data->user_id))',
                            ),
                        ),
                    ),
                ),
            ));?>
        </div>
    </div>
</div>


<div id="reason-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <?php echo CHtml::hiddenField('package_id', '', array('id'=>'package-id'));?>
                <?php echo CHtml::hiddenField('package_status', '', array('id'=>'package-status'));?>
                <?php echo CHtml::label('لطفا دلیل این انتخاب را بنویسید:', 'reason-text')?>
                <?php echo CHtml::textArea('reason', '', array('placeholder'=>'دلیل', 'class'=>'form-control', 'id'=>'reason-text'));?>
                <div class="reason-modal-message error"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default close-reason-modal" data-dismiss="modal">انصراف</button>
                <button type="button" class="btn btn-success save-reason-modal">ثبت</button>
            </div>
        </div>
    </div>
</div>
<?
endif;
?>
<div class="row">
    <div class="panel <?= $tickets['new']?'panel-success':'panel-default' ?> col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="panel-heading">
            پشتیبانی
        </div>
        <div class="panel-body">
            <p>
                تیکت های جدید: <?= $tickets['new'] ?>
            </p>
            <p>
                <?= CHtml::link('لیست تیکت ها',$this->createUrl('/tickets/manage/admin'),array('class'=>'btn btn-success')) ?>
            </p>
        </div>
    </div>
    <div class="panel panel-default col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="panel-heading">
            آمار بازدیدکنندگان
        </div>
        <div class="panel-body">
            <p>
                افراد آنلاین : <?php echo Yii::app()->userCounter->getOnline(); ?><br />
                بازدید امروز : <?php echo Yii::app()->userCounter->getToday(); ?><br />
                بازدید دیروز : <?php echo Yii::app()->userCounter->getYesterday(); ?><br />
                تعداد کل بازدید ها : <?php echo Yii::app()->userCounter->getTotal(); ?><br />
                بیشترین بازدید : <?php echo Yii::app()->userCounter->getMaximal(); ?><br />
            </p>
        </div>
    </div>
</div>