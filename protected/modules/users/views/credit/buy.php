<?php
/* @var $this CreditController */
/* @var $model Users */
/* @var $amounts Array */
?>

<div class="container">
    <div class="form">

    <?php echo CHtml::beginForm($this->createUrl('/users/credit/bill'));?>

        <?php if(Yii::app()->user->hasFlash('min_credit_fail')):?>
        <div class="alert alert-danger fade in">
            <button class="close close-sm" type="button" data-dismiss="alert"><i class="icon-remove"></i></button>
            <h3>اعتبار کافی نیست!</h3>
            <?php echo Yii::app()->user->getFlash('min_credit_fail');?>
        </div>
        <?php endif;?>

        <h1>خرید اعتبار</h1>
        <p>میزان اعتبار مورد نظر را انتخاب کنید:</p>
        <?php echo CHtml::radioButtonList('amount', '5000', $amounts);?>
        <div class="buttons">
            <?php echo CHtml::submitButton('خرید', array('class'=>'btn btn-success'));?>
        </div>

    <?php echo CHtml::endForm(); ?>

    </div><!-- form -->
</div>