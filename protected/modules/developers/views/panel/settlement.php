<?php
/* @var $this PanelController */
/* @var $form CActiveForm */
/* @var $userDetailsModel UserDetails */
/* @var $helpText string */
/* @var $settlementHistory CActiveDataProvider */
/* @var $formDisabled boolean */
?>

<div class="container">
    <ul class="nav nav-tabs">
        <li>
            <a href="<?php echo $this->createUrl('/developers/panel');?>">برنامه ها</a>
        </li>
        <li>
            <a href="<?php echo $this->createUrl('/developers/panel/account');?>">حساب توسعه دهنده</a>
        </li>
        <li>
            <a href="<?php echo $this->createUrl('/developers/panel/sales');?>">گزارش فروش</a>
        </li>
        <li class="active">
            <a href="<?php echo $this->createUrl('/developers/panel/settlement');?>">تسویه حساب</a>
        </li>
        <li>
            <a href="/developers/panel/support/?l=fa">پشتیبانی</a>
        </li>
        <li>
            <a href="/developers/panel/docs/?l=fa" target="_blank">مستندات</a>
        </li>
    </ul>

    <div class="tab-content card-container">
        <div class="tab-pane active">
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

            <div class="panel panel-warning settlement-help">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#help-box">راهنما</a>
                    </h4>
                </div>
                <div id="help-box" class="panel-collapse collapse">
                    <div class="panel-body"><?php echo CHtml::encode($helpText);?></div>
                </div>
            </div>

            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'user-details-form',
                // Please note: When you enable ajax validation, make sure the corresponding
                // controller action is handling ajax validation correctly.
                // There is a call to performAjaxValidation() commented in generated controller code.
                // See class documentation of CActiveForm for details on this.
                'enableAjaxValidation'=>true,
                'enableClientValidation'=>true,
                'clientOptions' => array(
                    'validateOnSubmit' => true
                ),
            ));?>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>تسویه حساب ماهانه</h3>
                        <div class="alert alert-danger">
                            <span><b>مبلغ قابل تسویه این ماه :</b> <?php echo number_format($userDetailsModel->getSettlementAmount(), 0);?> تومان</span>
                        </div>
                        <hr>
                        <div class="col-md-6">
                            <?php echo $form->checkBox($userDetailsModel, 'monthly_settlement', array(
                                'onchange'=>"$('#UserDetails_iban').prop('disabled', function(i, v){return !v;});",
                                'disabled'=>$formDisabled,
                            ));?>
                            <?php echo $form->label($userDetailsModel, 'monthly_settlement', array(
                                'style'=>'display:inline-block',
                            ));?>
                            <span>: مبلغ قابل تسویه 20اُم هر ماه به این شبا واریز شود.</span>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-8" style="padding: 0">
                                <?php echo $form->label($userDetailsModel, 'iban');?>
                                <div class="input-group" style="direction: ltr;">
                                    <span id="basic-addon1" class="input-group-addon">IR</span>
                                    <?php
                                    if(!$formDisabled)
                                        $disabled=(!is_null($userDetailsModel->iban))?false:true;
                                    else
                                        $disabled=true;
                                    ?>
                                    <?php echo $form->textField($userDetailsModel, 'iban', array(
                                        'class'=>'form-control',
                                        'aria-describedby'=>'basic-addon1',
                                        'style'=>'direction: ltr;',
                                        'placeholder'=>'10002000300040005000607:مثال',
                                        'disabled'=>$disabled,
                                    ));?>
                                </div>
                                <?php echo $form->error($userDetailsModel, 'iban');?>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <?php echo CHtml::submitButton('ثبت', array(
                                        'class'=>'btn btn-success pull-left',
                                        'id'=>'settlement-button',
                                        'disabled'=>$formDisabled,
                                    ));?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php $this->endWidget();?>

            <div class="panel panel-default settlement-history">
                <div class="panel-body">
                    <h3>تاریخچه تسویه حساب</h3>
                    <hr>
                    <div class="table text-center">
                        <div class="thead">
                            <div class="col-md-4">مبلغ</div>
                            <div class="col-md-4">تاریخ</div>
                            <div class="col-md-4">شماره شبا</div>
                        </div>
                        <div class="tbody">
                            <?php $this->widget('zii.widgets.CListView', array(
                                'dataProvider'=>$settlementHistory,
                                'itemView'=>'_settlement_list',
                                'template'=>'{items}'
                            ));?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>