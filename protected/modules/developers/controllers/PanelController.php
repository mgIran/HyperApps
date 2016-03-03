<?php

class PanelController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
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
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('account','index'),
                'roles'=>array('developer'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

	public function actionIndex()
	{
        Yii::app()->theme='market';
        $criteria=new CDbCriteria();
        $criteria->addCondition('developer_id = :user_id');
        $criteria->params=array(':user_id'=>Yii::app()->user->getId());
        $appsDataProvider=new CActiveDataProvider('Apps', array(
            'criteria'=>$criteria,
        ));
		$this->render('index', array(
            'appsDataProvider'=>$appsDataProvider,
        ));
	}

    /**
     * Update account
     */
    public function actionAccount()
    {
        Yii::app()->theme='market';
        Yii::import('application.modules.users.models.UserDetails');
        Yii::import('application.modules.users.models.UserDevIdRequests');

        $detailsModel=UserDetails::model()->findByAttributes(array('user_id'=>Yii::app()->user->getId()));
        $devIdRequestModel=UserDevIdRequests::model()->findByAttributes(array('user_id'=>Yii::app()->user->getId()));
        if($detailsModel->developer_id=='' && is_null($devIdRequestModel))
            $devIdRequestModel=new UserDevIdRequests();

        $detailsModel->scenario='update_profile';

        $this->performAjaxValidation($detailsModel);

        if(isset($_POST['UserDetails']))
        {
            unset($_POST['UserDetails']['credit']);
            $detailsModel->attributes=$_POST['UserDetails'];
            if($detailsModel->save())
            {
                Yii::app()->user->setFlash('success' , 'اطلاعات با موفقیت ثبت شد.');
                $this->refresh();
            }
            else
                Yii::app()->user->setFlash('fail' , 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }

        $this->render('account', array(
            'detailsModel'=>$detailsModel,
            'devIdRequestModel'=>$devIdRequestModel,
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param Apps $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']))
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}