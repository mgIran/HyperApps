<?php

class CreditController extends Controller
{
    public $layout='//layouts/panel';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'views' actions
                'actions'=>array('buy','bill','verify'),
                'users' => array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Buy Credit
     */
    public function actionBuy()
    {
        Yii::app()->theme = 'market';
        $this->layout = '//layouts/panel';
        $model=Users::model()->findByPk(Yii::app()->user->getId());
        Yii::import('application.modules.setting.models.*');
        $buyCreditOptions=SiteSetting::model()->findByAttributes(array('name'=>'buy_credit_options'));
        $amounts=array();
        foreach(CJSON::decode($buyCreditOptions->value) as $amount)
            $amounts[$amount]=Controller::parseNumbers(number_format($amount, 0)).' تومان';

        $this->render('buy', array(
            'model'=>$model,
            'amounts'=>$amounts,
        ));
    }

    /**
     * Show bill
     */
    public function actionBill()
    {
        Yii::app()->theme = 'market';
        if (isset($_POST['pay'])) {
            // Save payment
            $model = UserTransactions::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'status' => 'unpaid'));
            if (!$model)
                $model = new UserTransactions();
            $model->user_id = Yii::app()->user->getId();
            $model->amount = $_POST['amount'];
            $model->date = time();
            if ($model->save()) {
                $Amount = doubleval($model->amount) * 10;
                $CallbackURL = Yii::app()->getBaseUrl(true) . '/users/credit/verify';
                $result = Yii::app()->mellat->PayRequest($Amount, $model->id, $CallbackURL);
                if (!$result['error']) {
                    $ref_id = $result['responseCode'];
                    $this->render('ext.MellatPayment.views._redirect', array('ReferenceId' => $result['responseCode']));
                } else
                    Yii::app()->user->setFlash('failed', Yii::app()->mellat->getResponseText($result['responseCode']));
            } else
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است.');

            $this->render('bill', array(
                'model' => Users::model()->findByPk(Yii::app()->user->getId()),
                'amount' => CHtml::encode($_POST['amount']),
            ));
        } elseif (isset($_POST['amount'])) {
            $amount = CHtml::encode($_POST['amount']);
            $model = Users::model()->findByPk(Yii::app()->user->getId());
            $this->render('bill', array(
                'model' => $model,
                'amount' => CHtml::encode($amount),
            ));
        } else
            $this->redirect($this->createUrl('/users/credit/buy'));
    }

    public function actionVerify()
    {
        Yii::app()->theme='market';
        $this->layout='//layouts/panel';
        $model=UserTransactions::model()->findByAttributes(array('user_id'=>Yii::app()->user->getId(), 'status'=>'unpaid'));
        $userDetails=UserDetails::model()->findByAttributes(array('user_id'=>Yii::app()->user->getId()));
        /* @var $model UserTransactions */
        /* @var $userDetails UserDetails */

        $result=null;
        if($_POST['ResCode'] == 0)
            $result = Yii::app()->mellat->VerifyRequest($model->id, $_POST['SaleOrderId'], $_POST['SaleReferenceId']);

        if($result != null) {
            $RecourceCode = (!is_array($result) ? $result : $result['responseCode']);
            if($RecourceCode == 0) {
                // Settle Payment
                $settle = Yii::app()->mellat->SettleRequest($model->id, $_POST['SaleOrderId'], $_POST['SaleReferenceId']);
                if($settle) {
                    $model->status = 'paid';
                    $model->token = $_POST['SaleReferenceId'];
                    $model->description = 'خرید اعتبار از طریق درگاه بانک ملت';
                    $model->save();
                    // Increase credit
                    $userDetails->setScenario('update-credit');
                    $userDetails->credit = $userDetails->credit + $model->amount;
                    $userDetails->save();
                    Yii::app()->user->setFlash('success', 'پرداخت شما با موفقیت انجام شد.');

                    // Send email
                    $message =
                        '<p style="text-align: right;">با سلام<br>کاربر گرامی، تراکنش شما با موفقیت انجام شد. جزئیات تراکنش به شرح ذیل می باشد:</p>
                        <div style="width: 100%;height: 1px;background: #ccc;margin-bottom: 15px;"></div>
                        <table style="font-size: 9pt;text-align: right;">
                            <tr>
                                <td style="font-weight: bold;width: 120px;">زمان</td>
                                <td>' . JalaliDate::date('d F Y - H:i', $model->date) . '</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;width: 120px;">مبلغ</td>
                                <td>' . Controller::parseNumbers(number_format($model->amount, 0)) . ' تومان</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;width: 120px;">شناسه خرید</td>
                                <td>' . $model->id . '</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;width: 120px;">کد رهگیری</td>
                                <td>' . $model->token . '</td>
                            </tr>
                        </table>';
                    Mailer::mail($userDetails->user->email, 'رسید پرداخت اینترنتی', $message, Yii::app()->params['noReplyEmail'], Yii::app()->params['SMTP']);
                }
            }else{
                $error=Yii::app()->mellat->getError($RecourceCode);
                Yii::app()->user->setFlash('failed', 'عملیات پرداخت ناموفق بود.');
                Yii::app()->user->setFlash('transactionFailed', $error ? $error : 'در انجام عملیات پرداخت خطایی رخ داده است.');
            }
        }else
            Yii::app()->user->setFlash('failed', 'عملیات پرداخت ناموفق بوده یا توسط کاربر لغو شده است.');

        $this->render('verify', array(
            'model'=>$model,
            'userDetails'=>$userDetails,
        ));
    }
}