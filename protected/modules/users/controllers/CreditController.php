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
                'actions'=>array('buy','bill'),
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
            $amounts[$amount]=number_format($amount, 0).' تومان';

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
        if(isset($_POST['amount']))
        {
            Yii::app()->theme='market';
            $amount=CHtml::encode($_POST['amount']);
            $model=Users::model()->findByPk(Yii::app()->user->getId());
            $this->render('bill', array(
                'model'=>$model,
                'amount'=>$amount,
            ));
        }
        else
            $this->redirect($this->createUrl('/users/credit/buy'));
    }
}