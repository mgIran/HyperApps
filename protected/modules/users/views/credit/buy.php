<?php
/* @var $this CreditController */
/* @var $model Users */
/* @var $amounts Array */
?>

<div class="container">
    <div class="form col-md-6">

    <?php echo CHtml::beginForm($this->createUrl('/users/credit/bill'));?>

        <h1>خرید اعتبار</h1>
        <p>میزان اعتبار مورد نظر را انتخاب کنید:</p>
        <?php echo CHtml::radioButtonList('amount', '5000', $amounts);?>
        <div class="buttons">
            <?php echo CHtml::submitButton('خرید', array('class'=>'btn btn-success'));?>
        </div>

    <?php echo CHtml::endForm(); ?>

    </div><!-- form -->
</div>