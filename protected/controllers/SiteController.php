<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&views=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        Yii::app()->theme = 'market';
        $this->layout = '//layouts/public';
        $criteria=new CDbCriteria();
        $criteria->addCondition('path LIKE :regex1','OR');
        $criteria->addCondition('path LIKE :regex2','OR');
        $criteria->addCondition('id  = :id','OR');
        $criteria->params[':regex1'] = '1-%';
        $criteria->params[':regex2'] = '%-1-%';
        $criteria->params[':id'] = 1;
        $catIds=AppCategories::model()->findAll($criteria);
        $catIds = CHtml::listData($catIds,'id','id');
        $criteria = new CDbCriteria();
        $criteria->addInCondition('category_id',$catIds);
        $criteria->addCondition('platform_id=1');
        $criteria->limit=20;
        $newestProgramDataProvider=new CActiveDataProvider('Apps', array('criteria'=>$criteria));
        $criteria=new CDbCriteria();
        $criteria->addCondition('path LIKE :regex1','OR');
        $criteria->addCondition('path LIKE :regex2','OR');
        $criteria->addCondition('id  = :id','OR');
        $criteria->params[':regex1'] = '2-%';
        $criteria->params[':regex2'] = '%-2-%';
        $criteria->params[':id'] = 2;
        $catIds=AppCategories::model()->findAll($criteria);
        $catIds = CHtml::listData($catIds,'id','id');
        $criteria = new CDbCriteria();
        $criteria->addInCondition('category_id',$catIds);
        $criteria->addCondition('platform_id=1');
        $criteria->limit=20;
        $newestGameDataProvider=new CActiveDataProvider('Apps', array('criteria'=>$criteria));
	    $this->render('index', array(
            'newestProgramDataProvider'=>$newestProgramDataProvider,
            'newestGameDataProvider'=>$newestGameDataProvider,
        ));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
        Yii::app()->theme = 'market';
        $this->layout = '//layouts/public';
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
        Yii::import('users.models.*');
        Yii::import('users.components.*');
		$model=new UserLoginForm;
		// if it is ajax validation request
		if(isset($_POST['ajax']))
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['UserLoginForm']))
		{
			$model->attributes=$_POST['UserLoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				echo CJSON::encode(array('state' => 'ok'));
            else
                echo CJSON::encode(array('state' => 'error' ,'msg' => $this->implodeErrors($model)));
		}
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		if(!isset($_POST['ajaxReq']))
            $this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

    public function actionMyFavorites(){
        Yii::app()->theme = 'market';
        $this->layout = '//layouts/public';

        Yii::import('advertises.models.*');
        Yii::import('places.models.*');

        $favorites = array();
        if(isset($_COOKIE['favorites']))
            $favorites = CJSON::decode($_COOKIE['favorites']);
        $criteria = new CDbCriteria;
        $criteria->addInCondition('id' ,$favorites);
        $criteria->addCondition('valid = 1');
        $criteria->order = 'id DESC';
        $dataProvider = new CActiveDataProvider("Advertises",array(
           'criteria' => $criteria,
            'pagination' =>array(
                'pageSize' => 10
            )
        ));
        $this->render('my_favorites',array(
            'dataProvider' => $dataProvider
        ));
    }

    public function actionSendLink(){
        Yii::import('users.models.*');
        Yii::import('advertises.models.*');
        $model = new Users('email');
        if(isset($_POST)) {
            $model->email = $_POST[ 'email' ];
            if ( $model->validate() ) {
                $ads = Advertises::model()->findAll('user_email = :email' ,array(':email' => $model->email));
                if($ads){
                    $msg = '<h2 style="box-sizing:border-box;display: block;width: 100%;font-family:tahoma;background-color: #a1cf01;line-height:60px;color:#f7f7f7;font-size: 24px;text-align: right;padding-right: 50px">تابلو <span style="font-size: 14px;color:#dfdfdf">- نیازمندی های آنلاین</span></span> </h2>';
                    $msg .= '<div style="display: inline-block;width: 100%;font-family:tahoma;">';
                    foreach($ads as $ad){
                        $msg .= '<div style="direction:rtl;display:block;overflow:hidden;border:1px solid #efefef;text-align: center;margin:10px 20px;padding:15px;">';
                        $msg .= '<div style="color: #2d2d2d;font-size: 20px;text-align: right;">'.$ad->title.'</div>';
                        $msg .= '<div style="color: #444;font-size: 13px;text-align: right;">'.$ad->summary.'</div>';
                        $msg .= '<a style="display: inline-block;margin: 30px auto;background-color: #a1cf01;color: #fff;font-size: 16px;padding: 10px;border-radius:2px;box-shadow:0 0 3px rgba(0,0,0,0.1);text-decoration:none;" href="' . Yii::app()->createAbsoluteUrl("advertises/v/" . $ad->short_link) . '">لینک مدیریت آگهی</a>';
                        $msg .= '</div>';
                    }
                    $msg .= '</div>';
                    Yii::import('application.extensions.phpmailer.JPhpMailer');
                    $mail = new JPhpMailer;
                    //$mail->IsSMTP();
                    //$mail->Host = 'smpt.163.com';
                    //$mail->SMTPAuth = true;
                    //$mail->Username = 'yourname@163.com';
                    //$mail->Password = 'yourpassword';
                    $mail->SetFrom('noreply@market.ws' ,'تابلو');
                    $mail->Subject = 'تابلو';
                    $mail->AltBody = 'لینک مدیریت آگهی';
                    $mail->MsgHTML($msg);
                    $mail->AddAddress($_POST['email']);
                    if($mail->Send())
                        echo CJSON::encode(array('state' => 'ok' ,'msg' => 'لینک مدیریت آگهی برای شما فرستاده شد.'));
                    else
                        echo CJSON::encode(array('state' => 'error' ,'msg' => 'متاسفانه در ارسال لینک اختلال ایجاد شده است .لطفا مجددا سعی نمایید'));
                }
                else
                    echo CJSON::encode(array('state' => 'error' ,'msg' => 'توسط این آدرس آگهی ثبت نشده است'));
            } else
                echo CJSON::encode( array( 'state' => 'error', 'msg' => $this->implodeErrors($model)) );
        }
        Yii::app()->end();
    }

    public function actionRegister(){
        Yii::app()->theme = 'market';
        $this->layout = '//layouts/backgroundImage';
        Yii::import('users.models.*');
        $model = new Users('create');
        if ( isset( $_POST[ 'ajax' ] ) && $_POST[ 'ajax' ] === 'register-form' ) {
            echo CActiveForm::validate( $model );
            Yii::app()->end();
        }
        if(isset($_POST['Users']))
        {
            $model->attributes = $_POST['Users'];
            $pass = $_POST['Users']['password'];
            Yii::import('users.components.*');
            $login = new UserLoginForm;
            if($model->save())
            {
                $msg = '<h2 style="box-sizing:border-box;display: block;width: 100%;font-family:tahoma;background-color: #00ac1a;line-height:60px;color:#f7f7f7;font-size: 24px;text-align: right;padding-right: 50px">هایپر اپس<span style="font-size: 14px;color:#dfdfdf">- مرجع انواع نرم افزار تلفن های هوشمند</span></span> </h2>';
                $msg .= '<div style="display: inline-block;width: 100%;font-family:tahoma;">';
                $msg .= '<div style="direction:rtl;display:block;overflow:hidden;border:1px solid #efefef;text-align: center;margin:10px 20px;padding:15px;">';
                $msg .= '<div style="color: #2d2d2d;font-size: 20px;text-align: right;">ثبت نام با موفقیت انجام شد.</div>';
                $msg .= '<div style="color: #444;font-size: 13px;text-align: right;">';
                $msg .= '<p>نام کاربری (پست الکترونیک) : '.$model->email.'</p>';
                $msg .= '<p>رمز عبور : '.$_POST['Users']['password'].'</p>';
                $msg .= '</div>';
                $msg .= '</div>';
                $msg .= '</div>';
                Yii::import('application.extensions.phpmailer.JPhpMailer');
                $mail = new JPhpMailer;
                //$mail->IsSMTP();
                //$mail->Host = 'smpt.163.com';
                //$mail->SMTPAuth = true;
                //$mail->Username = 'yourname@163.com';
                //$mail->Password = 'yourpassword';
                $mail->SetFrom(Yii::app()->params['no-reply-email'],Yii::app()->name);
                $mail->Subject = 'ثبت نام در '.Yii::app()->name;
                $mail->MsgHTML($msg);
                $mail->AddAddress($model->email);
                $mail->Send();
                $msg = 'ثبت نام با موفقیت انجام شد.';

                $login->attributes = $_POST['Users'];
                $login->password = $pass;
                if($login->validate() && $login->login())
                    if(Yii::app()->user->returnUrl != Yii::app()->request->baseUrl.'/')
                        $this->redirect(Yii::app()->user->returnUrl);
                    else
                        $this->redirect(Yii::app()->createAbsoluteUrl('//'));
            }
        }
        $this->render( 'register', array( 'model' => $model ) );
    }

    public function actionAbout(){
        Yii::import('pages.models.*');
        Yii::app()->theme = 'market';
        $this->layout = '//layouts/public';
        $model = Pages::model()->findByPk(2);
        $this->render('//site/pages/page',array('model' => $model));
    }

    public function actionContactUs(){
        Yii::import('pages.models.*');
        Yii::app()->theme = 'market';
        $this->layout = '//layouts/public';
        $model = Pages::model()->findByPk(3);
        $this->render('//site/pages/page',array('model' => $model));
    }


    public function actionTerms(){
        Yii::import('pages.models.*');
        Yii::app()->theme = 'market';
        $this->layout = '//layouts/public';
        $model = Pages::model()->findByPk(5);
        $this->render('//site/pages/page',array('model' => $model));
    }


   public function actionGuidance(){
        Yii::import('pages.models.*');
        Yii::app()->theme = 'market';
        $this->layout = '//layouts/public';
        $dataProvider = new CActiveDataProvider("Pages",array(
            'criteria' => array(
                'condition' => 'category_id = 2'
            ),
            'pagination' => array(
                'pageSize' => 10
            )
        ));
       $dataProvider2 = new CActiveDataProvider("Pages",array(
           'criteria' => array(
               'condition' => 'category_id = 3'
           ),
           'pagination' => array(
               'pageSize' => 10
           )
       ));
        $this->sideRender = array(
            '//layouts/_support'
        );
        $this->render('//site/pages/guidance',array('dataProvider' => $dataProvider,'dataProvider2' => $dataProvider2));
    }

}