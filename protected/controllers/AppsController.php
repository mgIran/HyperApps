<?php

class AppsController extends Controller
{
    public $layout = '//layouts/inner';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + bookmark',
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
            array('allow',
                'actions'=>array('view','download','programs','games','educations'),
                'users'=>array('*'),
            ),
            array('allow',
                'actions'=>array('buy','bookmark'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

	public function actionView($id)
    {
        Yii::import('users.models.*');
        Yii::app()->theme = "market";
        $model = $this->loadModel($id);
        $model->seen=$model->seen+1;
        $model->save();
        $this->saveInCookie($model->category_id);
        // Get similar apps
        $criteria = new CDbCriteria();
        $criteria->addCondition('id!=:id');
        $criteria->addCondition('category_id=:cat_id');
        $criteria->addCondition('platform_id=:platform_id');
        $criteria->addCondition('status=:status');
        $criteria->addCondition('confirm=:confirm');
        $criteria->addCondition('deleted=:deleted');
        $criteria->order='install DESC, seen DESC';
        $criteria->params[':id']=$model->id;
        $criteria->params[':cat_id']=$model->category_id;
        $criteria->params[':platform_id']=$model->platform_id;
        $criteria->params[':status']='enable';
        $criteria->params[':confirm']='accepted';
        $criteria->params[':deleted']=0;
        $criteria->limit=20;
        $similar=new CActiveDataProvider('Apps', array('criteria'=>$criteria));
		$this->render('view',array(
            'model' => $model,
            'similar' => $similar,
        ));
	}

    /**
     * Buy app
     */
    public function actionBuy($id, $title)
    {
        Yii::app()->theme='market';
        $this->layout='panel';

        $model=$this->loadModel($id);

        $buy=AppBuys::model()->findByAttributes(array('user_id'=>Yii::app()->user->getId(), 'app_id'=>$id));
        if($buy)
            $this->redirect(array('/apps/download/'.CHtml::encode($model->id).'/'.CHtml::encode($model->title)));

        Yii::app()->getModule('users');
        $user=Users::model()->findByPk(Yii::app()->user->getId());

        if(isset($_POST['buy']))
        {
            if($user->userDetails->credit<$model->price)
            {
                Yii::app()->user->setFlash('fail' , 'اعتبار فعلی شما کافی نیست!');
                Yii::app()->user->setFlash('failReason' , 'min_credit');
                $this->refresh();
            }

            $buy=new AppBuys();
            $buy->app_id=$model->id;
            $buy->user_id=$user->id;
            if($buy->save())
            {
                $userDetails=UserDetails::model()->findByAttributes(array('user_id'=>Yii::app()->user->getId()));
                $userDetails->credit=$userDetails->credit-$model->price;
                if($userDetails->save())
                    $this->redirect(array('/apps/download/'.CHtml::encode($model->id).'/'.CHtml::encode($model->title)));
            }
        }

        $this->render('buy', array(
            'model'=>$model,
            'user'=>$user,
            'bought'=>($buy)?true:false,
        ));
    }

    /**
     * Download app
     */
    public function actionDownload($id, $title)
    {
        $model=$this->loadModel($id);
        $platformFolder='';
        switch(pathinfo($model->file_name, PATHINFO_EXTENSION))
        {
            case 'apk':
                $platformFolder='android';
                break;

            case 'ipa':
                $platformFolder='ios';
                break;

            case 'xap':
                $platformFolder='windowsphone';
                break;
        }
        if($model->price==0) {
            $model->install=$model->install+1;
            $model->save();
            $this->download($model->file_name, Yii::getPathOfAlias("webroot") . '/uploads/apps/files/' . $platformFolder);
        }
        else
        {
            $buy=AppBuys::model()->findByAttributes(array('user_id'=>Yii::app()->user->getId(), 'app_id'=>$id));
            if($buy) {
                $model->install=$model->install+1;
                $model->save();
                $this->download($model->file_name, Yii::getPathOfAlias("webroot") . '/uploads/apps/files/' . $platformFolder);
            }
            else
                $this->redirect(array('/apps/buy/'.CHtml::encode($model->id).'/'.CHtml::encode($model->title)));
        }
    }

    protected function download($fileName, $filePath)
    {
        $fakeFileName=$fileName;
        $realFileName=$fileName;

        $file = $filePath.DIRECTORY_SEPARATOR.$realFileName;
        $fp = fopen($file, 'rb');

        $mimeType='';
        switch(pathinfo($fileName, PATHINFO_EXTENSION))
        {
            case 'apk':
                $mimeType='application/vnd.android.package-archive';
                break;

            case 'xap':
                $mimeType='application/x-silverlight-app';
                break;

            case 'ipa':
                $mimeType='application/octet-stream';
                break;
        }

        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Transfer-Encoding: binary');
        header('Content-Type: text/html');
        header('Content-Disposition: attachment; filename='.$fakeFileName);

        echo stream_get_contents($fp,-1,0);
    }

    /**
     * Show programs list
     */
    public function actionPrograms($id=null, $title=null)
    {
        if(is_null($id))
            $id=1;
        $this->showCategory($id, $title, 'برنامه ها');
    }

    /**
     * Show games list
     */
    public function actionGames($id=null, $title=null)
    {
        if(is_null($id))
            $id=2;
        $this->showCategory($id, $title, 'بازی ها');
    }

    /**
     * Show educations list
     */
    public function actionEducations($id=null, $title=null)
    {
        if(is_null($id))
            $id=3;
        $this->showCategory($id, $title, 'آموزش ها');
    }

    /**
     * Show apps list of category
     */
    public function showCategory($id, $title, $pageTitle)
    {
        Yii::app()->theme='market';
        $this->layout='public';
        $criteria=new CDbCriteria();
        $criteria->addCondition('confirm=:confirm');
        $criteria->addCondition('deleted=:deleted');
        $criteria->addCondition('status=:status');
        $criteria->addCondition('platform_id=:platform');

        $criteria->params=array(
            ':confirm'=>'accepted',
            ':deleted'=>0,
            ':status'=>'enable',
            ':platform'=>$this->platform,
        );

        $categories=AppCategories::model()->getCategoryChilds($id);
        $criteria->addInCondition('category_id', $categories);

        $dataProvider=new CActiveDataProvider('Apps', array(
            'criteria'=>$criteria,
        ));

        $this->render('apps_list', array(
            'dataProvider'=>$dataProvider,
            'title'=>(!is_null($title))?$title:null,
            'pageTitle'=>$pageTitle
        ));
    }

    /**
     * Bookmark app
     */
    public function actionBookmark()
    {
        $model=new UserAppBookmark();
        $model->app_id=$_POST['appId'];
        $model->user_id=Yii::app()->user->getId();
        if($model->save())
            echo CJSON::encode(array(
                'status'=>true
            ));
        else
            echo CJSON::encode(array(
                'status'=>false
            ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Apps the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Apps::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
}