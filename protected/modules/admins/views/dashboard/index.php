<p>
    <?= Yii::app()->user->name; ?>
	خوش آمدید
</p>
<div class="panel panel-default col-lg-4 col-md-4 col-sm-6 col-xs-12">
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
