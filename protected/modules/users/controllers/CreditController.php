<?php

class CreditController extends Controller
{
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
                'actions'=>array('buy'),
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
        var_dump($buyCreditOptions);

        $this->render('buy', array(
            'model'=>$model,
        ));
    }
}