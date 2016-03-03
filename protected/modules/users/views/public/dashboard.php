<?php
/* @var $this PublicController */
/* @var $model Users */
?>
<div class="container">
    <ul class="nav nav-tabs">
        <li class="active">
            <a data-toggle="tab" href="#credit-tab">اعتبار</a>
        </li>
        <li>
            <a data-toggle="tab" onclick="loadTransactionsTab()" href="#tabs-transactions">تراکنش&zwnj;ها</a>
        </li>
        <li>
            <a data-toggle="tab" onclick="loadPurchasesTab()" href="#tabs-purchases">خریدها</a>
        </li>
        <li>
            <a data-toggle="tab" onclick="loadBookmarksTab()" href="#tabs-bookmarks">نشان&zwnj;ها</a>
        </li>
        <li>
            <a data-toggle="tab" href="#setting-tab">تنظیمات</a>
        </li>
        <li>
            <a href="<?php echo $this->createUrl('/developers/panel')?>">پنل توسعه دهندگان</a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="credit-tab" class="tab-pane fade in active">
            <?php $this->renderPartial('_credit',array(
                'model'=>$model,
            ))?>
        </div>
        <div id="setting-tab" class="tab-pane fade">
            <?php $this->renderPartial('_setting',array(
                'model'=>$model,
            ))?>
        </div>
    </div>
</div>