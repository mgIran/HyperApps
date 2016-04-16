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

        $catIds=AppCategories::model()->getCategoryChilds(1);
        $criteria = new CDbCriteria();
        $criteria->addInCondition('category_id',$catIds);
        $criteria->addCondition('platform_id=:platform_id');
        $criteria->addCondition('status=:status');
        $criteria->addCondition('confirm=:confirm');
        $criteria->addCondition('deleted=:deleted');
        $criteria->params[':platform_id']=$this->platform;
        $criteria->params[':status']='enable';
        $criteria->params[':confirm']='accepted';
        $criteria->params[':deleted']=0;
        $criteria->limit=20;
        $newestProgramDataProvider=new CActiveDataProvider('Apps', array('criteria'=>$criteria));

        $catIds=AppCategories::model()->getCategoryChilds(2);
        $criteria = new CDbCriteria();
        $criteria->addInCondition('category_id',$catIds);
        $criteria->addCondition('platform_id=:platform_id');
        $criteria->addCondition('status=:status');
        $criteria->addCondition('confirm=:confirm');
        $criteria->addCondition('deleted=:deleted');
        $criteria->params[':platform_id']=$this->platform;
        $criteria->params[':status']='enable';
        $criteria->params[':confirm']='accepted';
        $criteria->params[':deleted']=0;
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
        $this->layout = '//layouts/error';
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