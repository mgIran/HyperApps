<?php

class PublicController extends Controller
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
                'actions'=>array('dashboard','logout','setting'),
                'users' => array('@'),
            ),
            array('allow',  // allow all users to perform 'index' and 'views' actions
                'actions'=>array('login','verify'),
                'users' => array('*'),
                //'roles'=>array('admin','validator'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Login Action
     */
    public function actionLogin()
    {
        Yii::app()->theme = 'market';
        $this->layout = '//layouts/backgroundImage';
        if(!Yii::app()->user->isGuest && Yii::app()->user->type === 'user')
            $this->redirect(array('/site/'));

        $model = new UserLoginForm;
        // if it is ajax validation request
        if ( isset( $_POST[ 'ajax' ] ) && $_POST[ 'ajax' ] === 'login-form' ) {
            echo CActiveForm::validate( $model );
            Yii::app()->end();
        }

        // collect user input data
        if ( isset( $_POST[ 'UserLoginForm' ] ) ) {
            $model->attributes = $_POST[ 'UserLoginForm' ];
            // validate user input and redirect to the previous page if valid
            if ( $model->validate() && $model->login())
                if(Yii::app()->user->returnUrl != Yii::app()->request->baseUrl.'/')
                    $this->redirect(Yii::app()->user->returnUrl);
                else
                    $this->redirect($this->createUrl('/dashboard'));
        }
        // display the login form
        $this->render( 'login', array( 'model' => $model ) );
    }

    /**
     * Logout Action
     */
    public function actionLogout() {
        Yii::app()->user->logout(false);
        $this->redirect(array('/users/login'));
    }

    /**
     * Dashboard Action
     */
    public function actionDashboard()
    {
        Yii::app()->theme = 'market';
        $this->layout = '//layouts/panel';
        $model=Users::model()->findByPk(Yii::app()->user->getId());
        $this->render('dashboard', array(
            'model'=>$model,
        ));
    }

    /**
     * Change password
     */
    public function actionSetting()
    {
        Yii::app()->theme = 'market';
        $this->layout = '//layouts/panel';
        $model=Users::model()->findByPk(Yii::app()->user->getId());
        $model->setScenario('update');

        $this->performAjaxValidation($model);

        if(isset($_POST['Users']))
        {
            $model->attributes=$_POST['Users'];
            if($model->validate())
            {
                $model->password=$_POST['Users']['newPassword'];
                if($model->save())
                {
                    Yii::app()->user->setFlash('success' , 'اطلاعات با موفقیت ثبت شد.');
                    $this->redirect($this->createUrl('/dashboard'));
                }
                else
                    Yii::app()->user->setFlash('fail' , 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
            }
        }

        $this->render('setting', array(
            'model'=>$model,
        ));
    }

    /**
     * Verify email
     */
    public function actionVerify()
    {
        $token=Yii::app()->request->getQuery('token');
        $model=Users::model()->find('verification_token=:token', array(':token'=>$token));
        if(time() <= $model->create_date+259200)
        {
            $model->updateByPk($model->id, array('status'=>'active'));
            Yii::app()->user->setFlash('success' , 'حساب کاربری شما فعال گردید. هم اکنون می توانید وارد شوید.');
            $this->redirect($this->createUrl('/login'));
        }
    }

    /**
     * Performs the AJAX validation.
     * @param Apps $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}