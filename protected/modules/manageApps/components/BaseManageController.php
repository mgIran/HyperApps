<?php

class BaseManageController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    protected $platform_id = null;
    protected $controller = null;
    protected $formats = null;

    public function beforeAction($action)
    {
        $url = explode('/' ,Yii::app()->urlManager->parseUrl(Yii::app()->request));
        $this->controller = $url[1];

        if($action->id == 'create' || $action->id == 'update'){
            $platform = AppPlatforms::model()->findByPk($this->platform_id);
            $formats = explode(',' ,$platform->file_types);
            if(count($formats) > 1){
                foreach($formats as $key => $format){
                    $format = '.' . trim($format);
                    $formats[$key] = $format;
                }
                $this->formats = implode(',' ,$formats);
            }else
                $this->formats = '.' . trim($formats[0]);
        }
        return true;
    }

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl' , // perform access control for CRUD operations
            'postOnly + delete' , // we only allow deletion via POST request
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
            array('allow' ,  // allow all users to perform 'index' and 'view' actions
                'actions' => array('index' ,'view' ,'create' ,'update' ,'admin' ,'delete' ,'upload' ,'deleteUpload','uploadFile' ,'deleteUploadFile') ,
                'roles' => array('admin') ,
            ) ,
            array('deny' ,  // deny all users
                'users' => array('*') ,
            ) ,
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view' ,array(
            'model' => $this->loadModel($id) ,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Apps;

        $step = 1;
        $tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
        if(!is_dir($tmpDIR))
            mkdir($tmpDIR);
        $tmpUrl = Yii::app()->createAbsoluteUrl('/uploads/temp/');
        $appFilesDIR = Yii::getPathOfAlias("webroot") . '/uploads/apps/files';
        $appIconsDIR = Yii::getPathOfAlias("webroot") . '/uploads/apps/icons';
        if(!is_dir($appIconsDIR)){
            mkdir($appIconsDIR);
            if(!is_dir($appIconsDIR . 'thumbs/')){
                mkdir($appIconsDIR . 'thumbs/');
                if(!is_dir($appIconsDIR . 'thumbs/90x90/')){
                    mkdir($appIconsDIR . 'thumbs/90x90/');
                }
            }
        }
        $image = array();
        $file = array();

        $this->performAjaxValidation($model);

        if(isset($_POST['Apps'])){
            if(isset($_POST['Apps']['file_name'])){
                $file = $_POST['Apps']['file_name'];
                $image = array(
                    array(
                        'name' => $file ,
                        'src' => $tmpUrl . '/' . $file ,
                        'size' => filesize($tmpDIR . $file) ,
                        'serverName' => $file ,
                    )
                );
            }

            if(isset($_POST['Apps']['icon'])){
                $file = $_POST['Apps']['icon'];
                $image = array(
                    array(
                        'name' => $file ,
                        'src' => $tmpUrl . '/' . $file ,
                        'size' => filesize($tmpDIR . $file) ,
                        'serverName' => $file ,
                    )
                );
            }

            $model->attributes = $_POST['Apps'];
            if($this->platform_id)
                $model->platform_id = $this->platform_id;
            if($model->save()){
                if($model->file_name){
                    rename($tmpDIR . $model->file_name ,$appFilesDIR . $model->file_name);
                }
                if($model->icon){
                    $thumbnail = new ThumbnailCreator();
                    $thumbnail->createThumbnail($tmpDIR . $model->file_name ,150 ,150 ,false ,$appIconsDIR . 'thumbs/90x90/' . $model->file_name);
                    unlink($tmpDIR . $model->file_name);
                }
                Yii::app()->user->setFlash('success' ,'دسته بندی با موفقیت افزوده شد.');
                $step = 2;
            }else
                Yii::app()->user->setFlash('failed' ,'درخواست با خطا مواجه است.');
        }

        $this->render('manageApps.views.baseManage.create' ,array(
            'model' => $model ,
            'image' => $image ,
            'file' => $file ,
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
        $tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/apps/icon/';
        if(!is_dir($tmpDIR))
            mkdir($tmpDIR);
        $tmpUrl = Yii::app()->createAbsoluteUrl('/uploads/apps/icon/');

        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        $image = array();
        if(file_exists($tmpDIR . $model->icon))
            $image = array(
                array(
                    'name' => $model->icon ,
                    'src' => $tmpUrl . '/' . $model->icon ,
                    'size' => filesize($tmpDIR . $model->icon) ,
                    'serverName' => $model->icon ,
                )
            );

        if(isset($_POST['Apps'])){
            $model->attributes = $_POST['Apps'];
            if($model->save())
                $this->redirect(array('view' ,'id' => $model->id));
        }

        $this->render('manageApps.views.baseManage.update' ,array(
            'model' => $model ,
            'image' => $image ,
            'step' => 1
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        if($model){
            if(file_exists(Yii::getPathOfAlias("webroot") . '/uploads/apps/files/' . $model->file_name))
                unlink(Yii::getPathOfAlias("webroot") . '/uploads/apps/files/' . $model->file_name);
            if(file_exists(Yii::getPathOfAlias("webroot") . '/uploads/apps/icons/' . $model->icon))
                unlink(Yii::getPathOfAlias("webroot") . '/uploads/apps/icons/' . $model->icon);
            $model->delete();
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Apps');
        $this->render('manageApps.views.baseManage.index' ,array(
            'dataProvider' => $dataProvider ,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Apps('search');
        $model->unsetAttributes();
        if(isset($_GET['Apps']))
            $model->attributes = $_GET['Apps'];
        if($this->platform_id)
            $model->platform_id = $this->platform_id;
        $this->render('manageApps.views.baseManage.admin' ,array(
            'model' => $model ,
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
        if($model === null)
            throw new CHttpException(404 ,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Apps $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax'] === 'apps-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionUpload()
    {
        $tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp';

        if(!is_dir($tempDir))
            mkdir($tempDir);
        if(isset($_FILES)){
            $file = $_FILES['icon'];
            $ext = end(explode('.' ,$file['name']));
            $file['name'] = Controller::generateRandomString(5) . time();
            while(file_exists($tempDir . DIRECTORY_SEPARATOR . $file['name']))
                $file['name'] = Controller::generateRandomString(5) . time();
            $file['name'] = $file['name'] . '.' . $ext;
            if(move_uploaded_file($file['tmp_name'] ,$tempDir . DIRECTORY_SEPARATOR . CHtml::encode($file['name'])))
                $response = ['state' => 'ok' ,'fileName' => CHtml::encode($file['name'])];
            else
                $response = ['state' => 'error' ,'msg' => 'فایل آپلود نشد.'];
        }else
            $response = ['state' => 'error' ,'msg' => 'فایلی ارسال نشده است.'];
        echo CJSON::encode($response);
        Yii::app()->end();
    }

    public function actionDeleteUpload()
    {
        $Dir = Yii::getPathOfAlias("webroot") . '/uploads/apps/icons/';

        if(isset($_POST['fileName'])){

            $fileName = $_POST['fileName'];

            $tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp/';

            $model = Apps::model()->findByAttributes(array('icon' => $fileName));
            if($model){
                if(@unlink($Dir . $fileName)){
                    $model->updateByPk($model->id ,array('icon' => null));
                    $response = ['state' => 'ok' ,'msg' => $this->implodeErrors($model)];
                }else
                    $response = ['state' => 'error' ,'msg' => 'مشکل ایجاد شده است'];
            }else{
                @unlink($tempDir . $fileName);
                $response = ['state' => 'ok' ,'msg' => 'حذف شد.'];
            }
            echo CJSON::encode($response);
            Yii::app()->end();
        }
    }

    public function actionUploadFile()
    {
        if(isset($_FILES['file_name'])){
            $tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp';
            if(!is_dir($tempDir))
                mkdir($tempDir);
            if(isset($_FILES)){
                $file = $_FILES['file_name'];
                $ext = end(explode('.' ,$file['name']));
                $file['name'] = Controller::generateRandomString(5) . time();
                while(file_exists($tempDir . DIRECTORY_SEPARATOR . $file['name']))
                    $file['name'] = Controller::generateRandomString(5) . time();
                $file['name'] = $file['name'] . '.' . $ext;
                if(move_uploaded_file($file['tmp_name'] ,$tempDir . DIRECTORY_SEPARATOR . CHtml::encode($file['name'])))
                    $response = ['state' => 'ok' ,'fileName' => CHtml::encode($file['name'])];
                else
                    $response = ['state' => 'error' ,'msg' => 'فایل آپلود نشد.'];
            }else
                $response = ['state' => 'error' ,'msg' => 'فایلی ارسال نشده است.'];
            echo CJSON::encode($response);
            Yii::app()->end();
        }
    }

    public function actionDeleteUploadFile()
    {
        $Dir = Yii::getPathOfAlias("webroot") . '/uploads/apps/files/';

        if(isset($_POST['fileName'])){

            $fileName = $_POST['fileName'];

            $tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp/';

            $model = Apps::model()->findByAttributes(array('file_name' => $fileName));
            if($model){
                if(@unlink($Dir . $fileName)){
                    $model->updateByPk($model->id ,array('file_name' => null));
                    $response = ['state' => 'ok' ,'msg' => $this->implodeErrors($model)];
                }else
                    $response = ['state' => 'error' ,'msg' => 'مشکل ایجاد شده است'];
            }else{
                @unlink($tempDir . $fileName);
                $response = ['state' => 'ok' ,'msg' => 'حذف شد.'];
            }
            echo CJSON::encode($response);
            Yii::app()->end();
        }
    }
}
