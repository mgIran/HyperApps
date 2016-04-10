<?php
/* @var $this PanelController */
/* @var $step String */
/* @var $agreementText String */
?>

<div class="container developer-signup-container">
    <div class="col-md-8 col-md-offset-2">
        <h2 class="text-center">توسعه دهنده شوید</h2>
        <div class="steps-container">
            <ul class="steps">
                <li<?php if($step=='agreement'):?> class="active"<?php endif;?>>
                    <span><span class="num">1</span>توافق نامه</span>
                    <div class="arrow"><div></div></div>
                </li>
                <li<?php if($step=='information'):?> class="active"<?php endif;?>>
                    <span><span class="num">2</span>اطلاعات قرارداد</span>
                    <div class="arrow"><div></div></div>
                </li>
                <li<?php if($step=='profile'):?> class="active"<?php endif;?>>
                    <span><span class="num">3</span>پروفایل</span>
                    <div class="arrow"><div></div></div>
                </li>
                <li<?php if($step=='finish'):?> class="active"<?php endif;?>>
                    <span><span class="num">4</span>اتمام</span>
                </li>
            </ul>
            <div class="step-content"></div>
                <?php switch($step){
                    case 'agreement':
                        $this->renderPartial('_agreement', array(
                            'text'=>$agreementText
                        ));

                    case 'information':
                        $this->renderPartial('_information', array());
                }?>
            </div>
        </div>
    </div>
</div>