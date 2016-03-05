<?php
/* @var $this CreditController */
/* @var $model Users */
?>

<div class="container">
    <p>میزان اعتبار مورد نظر را انتخاب کنید:</p>
    <?php echo CHtml::radioButtonList('amount', '5000', array('5000'=>'5,000 تومان', '10000'=>'10,000 تومان', '20000'=>'20,000 تومان', '50000'=>'50,000 تومان'));?>
    <div class="buttons">
        <?php echo CHtml::button('پرداخت', array('class'=>'btn btn-success'))?>
    </div>
</div>