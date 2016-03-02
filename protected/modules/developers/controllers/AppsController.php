<?php

class AppsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('create','update','delete','uploadImage','deleteImage'),
				'roles'=>array('developer'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        Yii::app()->theme='market';
        $this->layout='//layouts/panel';
		$model=new Apps;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Apps']))
		{
			$model->attributes=$_POST['Apps'];
            $model->permissions=CJSON::encode($_POST['Apps']['permissions']);
            $iconInstance=CUploadedFile::getInstance($model,'icon');
            $iconName=Yii::app()->user->username.'.'.$model->id.'.'.$iconInstance->extensionName;
            $model->file_name=CUploadedFile::getInstance($model,'file_name');
            $model->icon=$iconName;
            $model->developer_id=Yii::app()->user->getId();
            $model->size=$model->file_name->size;
			if($model->save())
            {
                $iconInstance->saveAs('uploads/apps/icons/'.$iconName);
                $model->file_name->saveAs('uploads/apps/files/'.$model->file_name->name);
                Yii::app()->user->setFlash('success' , 'اطلاعات با موفقیت ثبت شد.');
				$this->redirect(array('update/'.$model->id));
            }
            else
                Yii::app()->user->setFlash('fail' , 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
        Yii::app()->theme='market';
        $this->layout='//layouts/panel';
		$model=$this->loadModel($id);
        $images=array();
        $uploadDIR = Yii::getPathOfAlias("webroot") . '/uploads/apps/images/';
        foreach($model->images as $image)
        {
            if(file_exists($uploadDIR . $image->image))
            {
                $images[] = array(
                    'name' => $image->image ,
                    'src' => $uploadDIR . $image->image ,
                    'size' => filesize($uploadDIR . $image->image) ,
                    'serverName' => $image->image ,
                );
            }
        }

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Apps']))
		{
            unset($_POST['Apps']['icon']);
            unset($_POST['Apps']['file_name']);
			$model->attributes=$_POST['Apps'];
            $model->permissions=CJSON::encode($_POST['Apps']['permissions']);
            $prevIcon=$model->icon;
            $prevFile=$model->file_name;
            $iconInstance=CUploadedFile::getInstance($model,'icon');
            $fileInstance=CUploadedFile::getInstance($model,'file_name');
            if(!is_null($iconInstance))
            {
                $iconName=Yii::app()->user->username.'.'.$model->id.'.'.$iconInstance->extensionName;
                $model->icon=$iconName;
            }
            if(!is_null($fileInstance))
            {
                $model->file_name=$fileInstance;
                $model->size=$fileInstance->size;
            }
			if($model->save())
            {
                if(!is_null($iconInstance))
                {
                    @unlink(Yii::getPathOfAlias("webroot") . '/uploads/apps/files/'.$prevIcon);
                    $iconInstance->saveAs('uploads/apps/icons/'.$iconName);
                }
                if(!is_null($fileInstance))
                {
                    @unlink(Yii::getPathOfAlias("webroot") . '/uploads/apps/files/'.$prevFile);
                    $model->file_name->saveAs('uploads/apps/files/'.$model->file_name->name);
                }
                Yii::app()->user->setFlash('success' , 'اطلاعات با موفقیت ثبت شد.');
				$this->refresh();
            }
            else
                Yii::app()->user->setFlash('fail' , 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('update',array(
			'model'=>$model,
			'images'=>$images,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

    /**
     * Upload app images
     */
    public function actionUploadImage()
    {
        $uploadDir = Yii::getPathOfAlias( "webroot" ).'/uploads/apps/images';
        if(!is_dir($uploadDir))
            mkdir($uploadDir);
        if(isset($_FILES)) {
            $file = $_FILES[ 'image' ];
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $file['name'] = Controller::generateRandomString();
            while(file_exists($uploadDir.DIRECTORY_SEPARATOR.$file['name']))
                $file['name'] = Controller::generateRandomString();
            $file['name'] .= $file['name'].'.'.$ext;
            if ( move_uploaded_file( $file[ 'tmp_name' ], $uploadDir . DIRECTORY_SEPARATOR . CHtml::encode($file[ 'name' ] )) )
            {
                $response = [ 'state' => 'ok', 'fileName' => CHtml::encode($file[ 'name' ]) ];
                // Save image into db
                $model=new AppImages();
                $data=CJSON::decode($_POST['data']);
                $model->app_id=$data['app_id'];
                $model->image=$file['name'];
                $model->save();
            }
            else
                $response = [ 'state' => 'error', 'msg' => 'فایل آپلود نشد.' ];
        }else
            $response = [ 'state' => 'error', 'msg' => 'فایلی ارسال نشده است.' ];
        echo CJSON::encode($response);
        Yii::app()->end();
    }

    /**
     * Delete app images
     */
    public function actionDeleteImage()
    {
        if(isset($_POST['fileName']))
        {
            $fileName = $_POST[ 'fileName' ];
            $uploadDir = Yii::getPathOfAlias( "webroot" ) . '/uploads/apps/images/';

            $model = AppImages::model()->findByAttributes(array('image'=>$fileName));
            $response=null;
            if(!is_null($model))
            {
                if(@unlink($uploadDir.$fileName))
                {
                    $response = [ 'state' => 'ok', 'msg' => 'حذف شد.' ];
                    $model->delete();
                }
                else
                    $response = [ 'state' => 'error', 'msg' => 'مشکل ایجاد شده است' ];
            }
            echo CJSON::encode( $response );
            Yii::app()->end();
        }
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
		$model=Apps::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Apps $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='apps-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
