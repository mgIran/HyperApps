<?php
/* @var $this CreditController */
/* @var $amount string */
/* @var $model Users */
?>

<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">اطلاعات پرداخت</div>
        <div class="panel-body">
            <p>
                <?php echo CHtml::label('اعتبار فعلی شما: ','');?>
                <?php echo number_format($model->userDetails->credit, 0).' تومان';?>
            </p>
            <p>
                <?php echo CHtml::label('اعتبار درخواستی: ','');?>
                <?php echo number_format($model->userDetails->credit, 0).' تومان';?>
            </p>
        </div>
    </div>
</div>