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
    protected $filesFolder = null;

    public function beforeAction($action)
    {
        $url = explode('/', Yii::app()->urlManager->parseUrl(Yii::app()->request));
        $this->controller = $url[1];
        $this->filesFolder = $url[1];
        if(!is_dir(Yii::getPathOfAlias("webroot")."/uploads/apps/files/{$this->filesFolder}/"))
            mkdir(Yii::getPathOfAlias("webroot")."/uploads/apps/files/{$this->filesFolder}/");
        if ($action->id == 'create' || $action->id == 'update') {
            $platform = AppPlatforms::model()->findByPk($this->platform_id);
            $formats = explode(',', $platform->file_types);
            if (count($formats) > 1) {
                foreach ($formats as $key => $format) {
                    $format = '.' . trim($format);
                    $formats[$key] = $format;
                }
                $this->formats = implode(',', $formats);
            } else
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
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete', 'upload', 'deleteUpload', 'uploadFile', 'deleteUploadFile'),
                'roles' => array('admin'),
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
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
        if (!is_dir($tmpDIR))
            mkdir($tmpDIR);
        $tmpUrl = Yii::app()->createAbsoluteUrl('/uploads/temp/');
        $appFilesDIR = Yii::getPathOfAlias("webroot") . "/uploads/apps/files/{$this->filesFolder}/";
        $appIconsDIR = Yii::getPathOfAlias("webroot") . "/uploads/apps/icons/";

        $icon = array();
        $app = array();

        $this->performAjaxValidation($model);

        if (isset($_POST['Apps'])) {
            $model->attributes = $_POST['Apps'];
            if (isset($_POST['Apps']['file_name'])) {
                $file = $_POST['Apps']['file_name'];
                $app = array(
                    'name' => $file,
                    'src' => $tmpUrl . '/' . $file,
                    'size' => filesize($tmpDIR . $file),
                    'serverName' => $file,
                );
                $model->size = filesize($tmpDIR . $model->file_name);
            }

            if (isset($_POST['Apps']['icon'])) {
                $file = $_POST['Apps']['icon'];
                $icon = array(
                    'name' => $file,
                    'src' => $tmpUrl . '/' . $file,
                    'size' => filesize($tmpDIR . $file),
                    'serverName' => $file,
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
            if ($this->platform_id)
                $model->platform_id = $this->platform_id;
            $model->confirm='accepted';
            if ($model->save()) {
                if ($model->file_name) {
                    rename($tmpDIR . $model->file_name, $appFilesDIR . $model->file_name);
                }
                if ($model->icon) {
                    $thumbnail = new Imager();
                    $thumbnail->createThumbnail($tmpDIR . $model->icon, 150, 150, false, $appIconsDIR . $model->icon);
                    @unlink($tmpDIR . $model->icon);
                }
                Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ثبت شد.');
                $this->redirect('update/' . $model->id . '/?step=2');
                $step = 2;
            } else
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }

        $this->render('manageApps.views.baseManage.create', array(
            'model' => $model,
            'icon' => $icon,
            'app' => $app,
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
        $tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
        if(!is_dir($tmpDIR)) mkdir($tmpDIR);
        $tmpUrl = Yii::app()->createAbsoluteUrl('/uploads/temp/');
        $appFilesDIR = Yii::getPathOfAlias("webroot") . "/uploads/apps/files/{$this->filesFolder}/";
        $appIconsDIR = Yii::getPathOfAlias("webroot") . '/uploads/apps/icons/';
        $appImagesDIR = Yii::getPathOfAlias("webroot") . '/uploads/apps/images/';
        $appFilesUrl = Yii::app()->createAbsoluteUrl("/uploads/apps/files/{$this->filesFolder}");
        $appIconsUrl = Yii::app()->createAbsoluteUrl('/uploads/apps/icons');
        $appImagesUrl = Yii::app()->createAbsoluteUrl('/uploads/apps/images');

        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        $icon = array();
        if(file_exists($appIconsDIR . $model->icon))
            $icon = array(
                'name' => $model->icon,
                'src' => $appIconsUrl . '/' . $model->icon,
                'size' => filesize($appIconsDIR . $model->icon),
                'serverName' => $model->icon,
            );

        $app = array();
        if(file_exists($appFilesDIR . $model->file_name))
            $app = array(
                'name' => $model->file_name,
                'src' => $appFilesUrl . '/' . $model->file_name,
                'size' => filesize($appFilesDIR . $model->file_name),
                'serverName' => $model->file_name,
                );

        $images = array();
        if($model->images)
            foreach($model->images as $image)
                if(file_exists($appImagesDIR . $image->image))
                    $images[] = array(
                        'name' => $image->image,
                        'src' => $appImagesUrl . '/' . $image->image,
                        'size' => filesize($appImagesDIR . $image->image),
                        'serverName' => $image->image,
                    );
        if(isset($_POST['Apps'])) {
            $fileFlag = false;
            $iconFlag = false;
            $newFileSize = $model->size;
            if(isset($_POST['Apps']['file_name']) && !empty($_POST['Apps']['file_name']) && $_POST['Apps']['file_name'] != $model->file_name) {
                $file = $_POST['Apps']['file_name'];
                $app = array(
                    'name' => $file,
                    'src' => $tmpUrl . '/' . $file,
                    'size' => filesize($tmpDIR . $file),
                    'serverName' => $file,
                );
                $fileFlag = true;
                $newFileSize = filesize($tmpDIR . $file);
            }
            if(isset($_POST['Apps']['icon']) && !empty($_POST['Apps']['icon']) && $_POST['Apps']['icon'] != $model->icon) {
                $file = $_POST['Apps']['icon'];
                $icon = array('name' => $file, 'src' => $tmpUrl . '/' . $file, 'size' => filesize($tmpDIR . $file), 'serverName' => $file,);
                $iconFlag = true;
            }
            $model->attributes = $_POST['Apps'];
            $model->size = $newFileSize;
            if(count($_POST['Apps']['permissions']) > 0 && !empty($_POST['Apps']['permissions'][0])) {
                foreach($_POST['Apps']['permissions'] as $key => $permission) {
                    if(empty($permission)) unset($_POST['Apps']['permissions'][$key]);
                }
                $model->permissions = CJSON::encode($_POST['Apps']['permissions']);
            } else
                $model->permissions = null;
            if($model->save()) {
                if($fileFlag) {
                    rename($tmpDIR . $model->file_name, $appFilesDIR . $model->file_name);
                }
                if($iconFlag) {
                    $thumbnail = new Imager();
                    $thumbnail->createThumbnail($tmpDIR . $model->icon, 150, 150, false, $appIconsDIR . $model->icon);
                    unlink($tmpDIR . $model->icon);
                }
                Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت وایریش شد.');
                $this->refresh();
            } else {
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
            }
        }

        $this->render('manageApps.views.baseManage.update', array('model' => $model, 'icon' => $icon, 'app' => $app, 'images' => $images, 'step' => 1));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        if ($model) {
            if (file_exists(Yii::getPathOfAlias("webroot") . "/uploads/apps/files/{$this->filesFolder}/" . $model->file_name))
                unlink(Yii::getPathOfAlias("webroot") . "/uploads/apps/files/{$this->filesFolder}" . $model->file_name);
            if (file_exists(Yii::getPathOfAlias("webroot") . '/uploads/apps/icons/' . $model->icon))
                unlink(Yii::getPathOfAlias("webroot") . '/uploads/apps/icons/' . $model->icon);
            if ($model->images)
                foreach ($model->images as $image)
                    if (file_exists(Yii::getPathOfAlias("webroot") . '/uploads/apps/images/' . $image->$image))
                        unlink(Yii::getPathOfAlias("webroot") . '/uploads/apps/images/' . $image->$image);
            $model->delete();
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Apps');
        $this->render('manageApps.views.baseManage.index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Apps('search');
        $model->unsetAttributes();
        if (isset($_GET['Apps']))
            $model->attributes = $_GET['Apps'];
        if ($this->platform_id)
            $model->platform_id = $this->platform_id;
        $this->render('manageApps.views.baseManage.admin', array(
            'model' => $model,
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

    /**
     * Performs the AJAX validation.
     * @param Apps $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'apps-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

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
                if (@unlink($Dir . $model->icon)) {
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
        $Dir = Yii::getPathOfAlias("webroot") . "/uploads/apps/files/{$this->filesFolder}/";

        if (isset($_POST['fileName'])) {

            $fileName = $_POST['fileName'];

            $tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp/';

            $model = Apps::model()->findByAttributes(array('file_name' => $fileName));
            if ($model) {
                if (unlink($Dir . $model->file_name)) {
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
}
