<?php

class AppsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	private $filesFolder = null;
    public $formats = null;


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
				'actions'=>array('create','update','delete','uploadFile', 'upload', 'deleteUpload', 'uploadFile', 'deleteUploadFile'),
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
        $step = 1;
        $tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
        if (!is_dir($tmpDIR))
            mkdir($tmpDIR);
        $tmpUrl = Yii::app()->createAbsoluteUrl('/uploads/temp/');


        Yii::app()->theme = 'market';
        $this->layout = '//layouts/panel';
        $model = new Apps;
        $app = array();
        $icon = array();
        // Step 1
        if (isset($_POST['platform_id']))
            $model->platform_id = $_POST['platform_id'];
        if (isset($_POST['platform_id']) && !empty($_POST['platform_id'])) {
            $model->platform_id = (int)$_POST['platform_id'];
            $platform = AppPlatforms::model()->findByPk($model->platform_id);
            $formats = explode(',', $platform->file_types);
            if (count($formats) > 1) {
                foreach ($formats as $key => $format) {
                    $format = '.' . trim($format);
                    $formats[$key] = $format;
                }
                $this->formats = implode(',', $formats);
            } else
                $this->formats = '.' . trim($formats[0]);

            $this->filesFolder = $platform->name;
            if (!is_dir(Yii::getPathOfAlias("webroot") . "/uploads/apps/files/{$this->filesFolder}/"))
                mkdir(Yii::getPathOfAlias("webroot") . "/uploads/apps/files/{$this->filesFolder}/");
            $step = 2;
        } elseif (isset($_POST['platform_id']) && empty($_POST['platform_id']))
            Yii::app()->user->setFlash('failed', "لطفا یک گزینه را انتخاب کنید");

        $this->performAjaxValidation($model);

        // Step 2
        if (isset($_POST['Apps'])) {
            $model->attributes = $_POST['Apps'];
            if (isset($_POST['Apps']['file_name'])) {
                $file = $_POST['Apps']['file_name'];
                $app = array(
                    array(
                        'name' => $file,
                        'src' => $tmpUrl . '/' . $file,
                        'size' => filesize($tmpDIR . $file),
                        'serverName' => $file,
                    )
                );
                $model->size = filesize($tmpDIR . $model->file_name);
            }

            if (isset($_POST['Apps']['icon'])) {
                $file = $_POST['Apps']['icon'];
                $icon = array(
                    array(
                        'name' => $file,
                        'src' => $tmpUrl . '/' . $file,
                        'size' => filesize($tmpDIR . $file),
                        'serverName' => $file,
                    )
                );
            }
            if (count($_POST['Apps']['permissions']) > 0 && !empty($_POST['Apps']['permissions'][0])) {
                foreach ($_POST['Apps']['permissions'] as $key => $permission) {
                    if (empty($permission))
                        unset($_POST['Apps']['permissions'][$key]);
                }
                $model->permissions = CJSON::encode($_POST['Apps']['permissions']);
            } else
                $model->permissions = null;
            $model->developer_id = Yii::app()->user->getId();
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ثبت شد.');
                $this->redirect(array('apps/update/' . $model->id));
            } else
                Yii::app()->user->setFlash('fail', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }

        $this->render('create', array(
            'model' => $model,
            'icon' => $icon,
            'app' => $app,
            'images' => array(),
            'step' => $step
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
        if($model->images)
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
			$model->attributes=$_POST['Apps'];
            $model->permissions=CJSON::encode($_POST['Apps']['permissions']);

			if($model->save())
            {

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


	/**
	 * Upload And Delete App File and Icon Functions
	 */
	public function actionUpload()
	{
		$tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp';

		if (!is_dir($tempDir))
			mkdir($tempDir);
		if (isset($_FILES)) {
			$file = $_FILES['icon'];
			$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
			$file['name'] = Controller::generateRandomString(5) . time();
			while (file_exists($tempDir . DIRECTORY_SEPARATOR . $file['name']))
				$file['name'] = Controller::generateRandomString(5) . time();
			$file['name'] = $file['name'] . '.' . $ext;
			if (move_uploaded_file($file['tmp_name'], $tempDir . DIRECTORY_SEPARATOR . CHtml::encode($file['name'])))
				$response = ['state' => 'ok', 'fileName' => CHtml::encode($file['name'])];
			else
				$response = ['state' => 'error', 'msg' => 'فایل آپلود نشد.'];
		} else
			$response = ['state' => 'error', 'msg' => 'فایلی ارسال نشده است.'];
		echo CJSON::encode($response);
		Yii::app()->end();
	}

	public function actionDeleteUpload()
	{
		$Dir = Yii::getPathOfAlias("webroot") . '/uploads/apps/icons/';

		if (isset($_POST['fileName'])) {

			$fileName = $_POST['fileName'];

			$tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp/';

			$model = Apps::model()->findByAttributes(array('icon' => $fileName));
			if ($model) {
				if (@unlink($Dir . $fileName)) {
					$model->updateByPk($model->id, array('icon' => null));
					$response = ['state' => 'ok', 'msg' => $this->implodeErrors($model)];
				} else
					$response = ['state' => 'error', 'msg' => 'مشکل ایجاد شده است'];
			} else {
				@unlink($tempDir . $fileName);
				$response = ['state' => 'ok', 'msg' => 'حذف شد.'];
			}
			echo CJSON::encode($response);
			Yii::app()->end();
		}
	}

	public function actionUploadFile()
	{
		if (isset($_FILES['file_name'])) {
			$tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp';
			if (!is_dir($tempDir))
				mkdir($tempDir);
			if (isset($_FILES)) {
				$file = $_FILES['file_name'];
				$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
				$file['name'] = Controller::generateRandomString(5) . time();
				while (file_exists($tempDir . DIRECTORY_SEPARATOR . $file['name']))
					$file['name'] = Controller::generateRandomString(5) . time();
				$file['name'] = $file['name'] . '.' . $ext;
				if (move_uploaded_file($file['tmp_name'], $tempDir . DIRECTORY_SEPARATOR . CHtml::encode($file['name'])))
					$response = ['state' => 'ok', 'fileName' => CHtml::encode($file['name'])];
				else
					$response = ['state' => 'error', 'msg' => 'فایل آپلود نشد.'];
			} else
				$response = ['state' => 'error', 'msg' => 'فایلی ارسال نشده است.'];
			echo CJSON::encode($response);
			Yii::app()->end();
		}
	}

	public function actionDeleteUploadFile()
	{
        $data = CJSON::decode($_POST['data']);
        $this->filesFolder = $data['filesFolder'];
		$Dir = Yii::getPathOfAlias("webroot") . "/uploads/apps/files/{$this->filesFolder}/";

		if (isset($_POST['fileName'])) {

			$fileName = $_POST['fileName'];

			$tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp/';

			$model = Apps::model()->findByAttributes(array('file_name' => $fileName));
			if ($model) {
				if (unlink($Dir . $$model->fileName)) {
					$model->updateByPk($model->id, array('file_name' => null));
					$response = ['state' => 'ok', 'msg' => $this->implodeErrors($model)];
				} else
					$response = ['state' => 'error', 'msg' => 'مشکل ایجاد شده است'];
			} else {
				@unlink($tempDir . $fileName);
				$response = ['state' => 'ok', 'msg' => 'حذف شد.'];
			}
			echo CJSON::encode($response);
			Yii::app()->end();
		}
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
            $file['name'] = Controller::generateRandomString(5).time();
            while(file_exists($uploadDir.DIRECTORY_SEPARATOR.$file['name']))
                $file['name'] = Controller::generateRandomString(5).time();
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

}
