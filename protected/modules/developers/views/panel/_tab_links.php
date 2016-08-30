<?
/**
 * @var $active string
 */
if(!isset($active))
    $active = '';
?>
<ul class="nav nav-tabs">
    <li <?= $active == 'index'?'class="active"':'' ?> >
        <a href="<?php echo $this->createUrl('/developers/panel');?>">برنامه ها</a>
    </li>
    <li <?= $active == 'discount'?'class="active"':'' ?> >
        <a href="<?php echo $this->createUrl('/developers/panel/discount');?>">تخفیفات</a>
    </li>
    <li <?= $active == 'account'?'class="active"':'' ?> >
        <a href="<?php echo $this->createUrl('/developers/panel/account');?>">حساب توسعه دهنده</a>
    </li>
    <li <?= $active == 'sales'?'class="active"':'' ?> >
        <a href="<?php echo $this->createUrl('/developers/panel/sales');?>">گزارش فروش</a>
    </li>
    <li <?= $active == 'settlement'?'class="active"':'' ?> >
        <a href="<?php echo $this->createUrl('/developers/panel/settlement');?>">تسویه حساب</a>
    </li>
    <li>
        <a href="/developers/panel/docs/?l=fa" target="_blank">مستندات</a>
    </li>
</ul>