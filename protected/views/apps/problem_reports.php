<?php
/* @var $this BaseManageController */
/* @var $model Apps */

$this->breadcrumbs=array(
	'گزارش اشکالات',
);
?>
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">گزارش اشکالات</h3>
	</div>
	<div class="box-body">
		<div class="table-responsive">
			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'reports-grid',
				'dataProvider'=>$model->search(),
				'filter'=>$model,
				'template' => '{items} {pager}',
				'ajaxUpdate' => true,
				'afterAjaxUpdate' => "function(id, data){
					$('html, body').animate({
					scrollTop: ($('#'+id).offset().top-130)
					},1000,'easeOutCubic');
				}",
				'pager' => array(
					'header' => '',
					'firstPageLabel' => '<<',
					'lastPageLabel' => '>>',
					'prevPageLabel' => '<',
					'nextPageLabel' => '>',
					'cssFile' => false,
					'htmlOptions' => array(
						'class' => 'pagination pagination-sm',
					),
				),
				'pagerCssClass' => 'blank',
				'columns'=>array(
					array(
						'header' => 'برنامه',
						'value' => function($data){
                            return CHtml::link($data->app->title, array('/apps/'.$data->app->id.'/'.urlencode($data->app->lastPackage->package_name)));
                        },
						'filter' => CHtml::activeDropDownList($model,'app_id', CHtml::listData(Apps::model()->findAll('title != ""'),'id','title'),array('prompt' => 'برنامه مورد نظر را انتخاب کنید')),
                        'type' => 'raw'
					),
					'reason',
					'description:html',
                    array(
                        'header'=>'تغییر وضعیت نرم افزار',
                        'value'=>'CHtml::dropDownList("confirm", $data->app->confirm, $data->app->confirmLabels, array("class"=>"change-confirm", "data-id"=>$data->app->id))',
                        'type'=>'raw'
                    ),
//					array(
//						'class'=>'CButtonColumn',
//                        'template' => '{delete}',
//						'buttons' => array(
//							'view' => array(
//								'url'=>'Yii::app()->createUrl("/apps/".$data->id."/".urlencode($data->title))',
//								'options'=>array(
//									'target'=>'_blank'
//								),
//							)
//						)
//					),
				),
			)); ?>
		</div>
	</div>
</div>
<?php Yii::app()->clientScript->registerScript('changeConfirm', "
        $('body').on('change', '.change-confirm', function(){
            if(confirm(\"آیا از تغییر وضعیت این اپ اطمینان دارید؟\"))
                $.ajax({
                    url:'".$this->createUrl('/manageApps/android/changeConfirm')."',
                    type:'POST',
                    dataType:'JSON',
                    data:{app_id:$(this).data('id'), value:$(this).val()},
                    success:function(data){
                        if(data.status){
                            $.fn.yiiGridView.update('reports-grid');
                        }else
                            alert('در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید.');
                    }
                });
        });
    ");