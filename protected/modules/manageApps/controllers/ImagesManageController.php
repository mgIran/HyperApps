<?php

class ImagesManageController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('upload','deleteUploaded'),
                'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new AppImages;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AppImages']))
		{
			$model->attributes=$_POST['AppImages'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AppImages']))
		{
			$model->attributes=$_POST['AppImages'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('AppImages');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new AppImages('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AppImages']))
			$model->attributes=$_GET['AppImages'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AppImages the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=AppImages::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AppImages $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='app-images-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionUpload()
    {
        var_dump($_POST);exit;
        $tempDir = Yii::getPathOfAlias( "webroot" ).'/uploads/temp';
        if(!is_dir($tempDir))
            mkdir($tempDir);
        if(isset($_FILES)) {
            $file = $_FILES[ 'images' ];
            $ext = end(explode('.',$file['name']));
            $file['name'] = Controller::generateRandomString(5).time();
            while(file_exists($tempDir.DIRECTORY_SEPARATOR.$file['name']))
                $file['name'] = Controller::generateRandomString(5).time();
            $file['name'] .= $file['name'].'.'.$ext;
            if ( move_uploaded_file( $file[ 'tmp_name' ], $tempDir . DIRECTORY_SEPARATOR . CHtml::encode($file[ 'name' ] )) )
                $response = [ 'state' => 'ok', 'fileName' => CHtml::encode($file[ 'name' ]) ];
            else
                $response = [ 'state' => 'error', 'msg' => 'فایل آپلود نشد.' ];
        }else
            $response = [ 'state' => 'error', 'msg' => 'فایلی ارسال نشده است.' ];
        echo CJSON::encode($response);
        Yii::app()->end();
    }

    public function actionDeleteUpload()
    {
        if(isset($_POST['fileName'])) {

            $fileName = $_POST[ 'fileName' ];

            $tempDir = Yii::getPathOfAlias( "webroot" ) . '/uploads/temp/';
            $appDir = Yii::getPathOfAlias( "webroot" ) . '/uploads/apps/images';
            $appThumbDir = Yii::getPathOfAlias( "webroot" ) . '/uploads/apps/images/thumbs/90x90/';

            $model = AppImages::model()->findByAttributes( array( 'image' => $fileName ) );
            if ( $model ) {
                if ( @unlink( $appDir . $fileName ) ) {
                    @unlink( $appThumbDir . $fileName );
                    $model->delete();
                    $response = [ 'state' => 'ok', 'msg' => $this->implodeErrors($model) ];
                } else
                    $response = [ 'state' => 'error', 'msg' => 'مشکل ایجاد شده است' ];
            } else {
                @unlink( $tempDir . $fileName );
                $response = [ 'state' => 'ok', 'msg' => 'حذف شد.' ];
            }
            echo CJSON::encode( $response );
            Yii::app()->end();
        }
    }
}
