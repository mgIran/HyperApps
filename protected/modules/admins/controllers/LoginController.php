<?php

class LoginController extends Controller
{
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
     * Index Action
     */
    public function actionIndex()
    {
        Yii::app()->theme = 'abound';
        $this->layout = '//layouts/login';
        if(!Yii::app()->user->isGuest && Yii::app()->user->type === 'admin')
            $this->redirect(array('/admins/'));

        $model = new AdminLoginForm;
        // if it is ajax validation request
        if ( isset( $_POST[ 'ajax' ] ) && $_POST[ 'ajax' ] === 'login-form' ) {
            echo CActiveForm::validate( $model );
            Yii::app()->end();
        }

// collect user input data
        if ( isset( $_POST[ 'AdminLoginForm' ] ) ) {
            $model->attributes = $_POST[ 'AdminLoginForm' ];
            // validate user input and redirect to the previous page if valid
            if ( $model->validate() && $model->login())
                $this->redirect(Yii::app()->createUrl('/admins/'));
        }
// display the login form
        $this->render( 'index', array( 'model' => $model ) );
    }

    /**
     * Action Logout
     */
    public function actionLogout() {
        Yii::app()->user->logout(false);
        $this->redirect(array('/admins/login'));
    }
}