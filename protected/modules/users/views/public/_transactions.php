<?php
/* @var $this PublicController */
/* @var $model Users */
?>

<div class="container-fluid">
    <?php if(empty($model->transactions)):?>
        نتیجه ای یافت نشد.
    <?php else:?>
        <div class="table text-center">
            <div class="thead">
                <div class="td col-md-3">زمان</div>
                <div class="td col-md-3">مبلغ</div>
                <div class="td col-md-3">توضیحات</div>
                <div class="td col-md-3">کد رهگیری</div>
            </div>
            <div class="tbody">
                <?php foreach($model->transactions as $transaction):?>
                    <div class="tr">
                        <div class="col-md-3"><?php echo JalaliDate::date('d F Y - H:i', $transaction->date);?></div>
                        <div class="col-md-3"><?php echo number_format($transaction->amount, 0).' تومان';?></div>
                        <div class="col-md-3"><?php echo CHtml::encode($transaction->description);?></div>
                        <div class="col-md-3"><?php echo CHtml::encode($transaction->token);?></div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    <?php endif;?>
</div>
