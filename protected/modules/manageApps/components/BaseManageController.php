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
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete', 'upload', 'deleteUpload', 'uploadFile', 'deleteUploadFile', 'changeConfirm', 'changePackageStatus', 'deletePackage', 'savePackage', 'images'),
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
        $tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
        if (!is_dir($tmpDIR))
            mkdir($tmpDIR);
        $tmpUrl = Yii::app()->createAbsoluteUrl('/uploads/temp/');
        $appIconsDIR = Yii::getPathOfAlias("webroot") . "/uploads/apps/icons/";
        $icon = array();

        $this->performAjaxValidation($model);

        if (isset($_POST['Apps'])) {
            $model->attributes = $_POST['Apps'];
            if (isset($_POST['Apps']['icon'])) {
                $file = $_POST['Apps']['icon'];
                $icon = array(
                    'name' => $file,
                    'src' => $tmpUrl . '/' . $file,
                    'size' => filesize($tmpDIR . $file),
                    'serverName' => $file,
                );
            }
            if(isset($_POST['Apps']['permissions'])) {
                if (count($_POST['Apps']['permissions']) > 0 && !empty($_POST['Apps']['permissions'][0])) {
                    foreach ($_POST['Apps']['permissions'] as $key => $permission) {
                        if (empty($permission))
                            unset($_POST['Apps']['permissions'][$key]);
                    }
                    $model->permissions = CJSON::encode($_POST['Apps']['permissions']);
                } else
                    $model->permissions = null;
            }
            if ($this->platform_id)
                $model->platform_id = $this->platform_id;
            $model->confirm='accepted';
            $pt = $_POST['priceType'];
            switch($pt){
                case 'free':
                    $model->price = 0;
                    break;
                case 'online-payment':
                    break;
                case 'in-app-payment':
                    $model->price = -1;
                    break;
            }
            if ($model->save()) {
                if ($model->icon) {
                    $thumbnail = new Imager();
                    $thumbnail->createThumbnail($tmpDIR . $model->icon, 150, 150, false, $appIconsDIR . $model->icon);
                    @unlink($tmpDIR . $model->icon);
                }
                Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ثبت شد.');
                $this->redirect('update/' . $model->id . '/?step=2');
            } else
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }

        Yii::app()->getModule('setting');
        $this->render('manageApps.views.baseManage.create', array(
            'model' => $model,
            'icon' => $icon,
            'tax'=>SiteSetting::model()->findByAttributes(array('name'=>'tax'))->value,
            'commission'=>SiteSetting::model()->findByAttributes(array('name'=>'commission'))->value,
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
            if(isset($_POST['Apps']['permissions'])) {
                if (count($_POST['Apps']['permissions']) > 0 && !empty($_POST['Apps']['permissions'][0])) {
                    foreach ($_POST['Apps']['permissions'] as $key => $permission) {
                        if (empty($permission)) unset($_POST['Apps']['permissions'][$key]);
                    }
                    $model->permissions = CJSON::encode($_POST['Apps']['permissions']);
                } else
                    $model->permissions = null;
            }
            $pt = $_POST['priceType'];
            switch($pt){
                case 'free':
                    $model->price = 0;
                    break;
                case 'online-payment':
                    break;
                case 'in-app-payment':
                    $model->price = -1;
                    break;
            }
            if($model->save()) {
                if($fileFlag) {
                    rename($tmpDIR . $model->file_name, $appFilesDIR . $model->file_name);
                }
                if($iconFlag) {
                    $thumbnail = new Imager();
                    $thumbnail->createThumbnail($tmpDIR . $model->icon, 150, 150, false, $appIconsDIR . $model->icon);
                    unlink($tmpDIR . $model->icon);
                }
                Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ویرایش شد.');
                $this->refresh();
            } else {
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
            }
        }

        $criteria=new CDbCriteria();
        $criteria->addCondition('app_id=:app_id');
        $criteria->params=array(
            ':app_id'=>$id,
        );
        $packageDataProvider=new CActiveDataProvider('AppPackages', array('criteria'=>$criteria));

        Yii::app()->getModule('setting');
        $this->render('manageApps.views.baseManage.update', array(
            'model' => $model,
            'icon' => $icon,
            'images' => $images,
            'step' => 1,
            'packageDataProvider'=>$packageDataProvider,
            'tax'=>SiteSetting::model()->findByAttributes(array('name'=>'tax'))->value,
            'commission'=>SiteSetting::model()->findByAttributes(array('name'=>'commission'))->value,
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
        $model->deleted=1;
        $model->setScenario('delete');
        if($model->save())
            $this->createLog('برنامه '.$model->title.' توسط مدیر سیستم حذف شد.', $model->developer_id);

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
            if (move_uploaded_file($file['tmp_name'], $tempDir . DIRECTORY_SEPARATOR . CHtml::encode($file['name']))) {
                $imager = new Imager();
                $imageInfo = $imager->getImageInfo($tempDir . DIRECTORY_SEPARATOR . $file['name']);
                if($imageInfo['width'] < 512 or $imageInfo['height'] < 512) {
                    $response = ['state' => 'error', 'msg' => 'اندازه آیکون نباید کوچکتر از 512x512 پیکسل باشد.'];
                    unlink($tempDir . DIRECTORY_SEPARATOR . $file['name']);
                }else
                    $response = ['state' => 'ok', 'fileName' => CHtml::encode($file['name'])];
            }else
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
                $file['name'] = str_replace(' ', '_', $file['name']);
                $file['name'] = time() . '-' . $file['name'];
                if (move_uploaded_file($file['tmp_name'], $tempDir . DIRECTORY_SEPARATOR . $file['name']))
                    $response = ['status' => true, 'fileName' => CHtml::encode($file['name'])];
                else
                    $response = ['status' => false, 'message' => 'در عملیات آپلود فایل خطایی رخ داده است.'];
            } else
                $response = ['status' => false, 'message' => 'فایلی ارسال نشده است.'];
            echo CJSON::encode($response);
            Yii::app()->end();
        }
    }

    public function actionDeleteUploadFile()
    {
        echo CJSON::encode(['state' => 'ok', 'msg' => 'فایل با موفقیت حذف شد.']);
    }

    public function actionChangeConfirm()
    {
        $model=$this->loadModel($_POST['app_id']);
        $model->confirm=$_POST['value'];
        if($model->save()) {
            if($_POST['value']=='accepted') {
                $package = AppPackages::model()->find(array('condition' => 'app_id=:app_id', 'params' => array(':app_id' => $model->id), 'order' => 'id DESC'));
                $package->publish_date = time();
                $package->status='accepted';
                $package->setScenario('publish');
                $package->save();
            }
            $message='';
            switch($_POST['value'])
            {
                case 'refused':
                    $message='برنامه '.$model->title.' رد شده است.';
                    break;

                case 'accepted':
                    $message='برنامه '.$model->title.' تایید شده است.';
                    break;

                case 'change_required':
                    $message='برنامه '.$model->title.' نیاز به تغییرات دارد.';
                    break;
            }
            $this->createLog($message, $model->developer_id);
            echo CJSON::encode(array(
                'status' => true
            ));
        }
        else
            echo CJSON::encode(array(
                'status'=>false
            ));
    }

    public function actionChangePackageStatus()
    {
        if (isset($_POST['package_id'])) {
            $model = AppPackages::model()->findByPk($_POST['package_id']);
            $model->status = $_POST['value'];
            $model->setScenario('publish');
            if ($_POST['value'] == 'accepted')
                $model->publish_date = time();
            if ($_POST['value'] == 'refused' or $_POST['value'] == 'change_required')
                $model->reason = $_POST['reason'];
            if ($model->save()) {
                if ($_POST['value'] == 'accepted')
                    $this->createLog('بسته ' . $model->package_name . ' توسط مدیر سیستم تایید شد.', $model->app->developer_id);
                elseif ($_POST['value'] == 'refused')
                    $this->createLog('بسته ' . $model->package_name . ' توسط مدیر سیستم رد شد.', $model->app->developer_id);
                elseif ($_POST['value'] == 'change_required')
                    $this->createLog('بسته ' . $model->package_name . ' نیاز به تغییر دارد.', $model->app->developer_id);
                echo CJSON::encode(array('status' => true));
            } else
                echo CJSON::encode(array('status' => false));
        }
    }

    public function actionDeletePackage($id)
    {
        $model=AppPackages::model()->findByPk($id);
        $uploadDir = Yii::getPathOfAlias("webroot") . '/uploads/apps/files/'.$model->app->platform->name;
        if(file_exists($uploadDir.'/'.$model->file_name))
            if(unlink($uploadDir.'/'.$model->file_name))
                if($model->delete())
                    $this->createLog('بسته ' . $model->package_name . ' توسط مدیر سیستم حذف شد.', $model->app->developer_id);

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Return APK file info
     * @param string $filename file name
     * @return array of apk file info
     */
    public function apkParser($filename)
    {
        Yii::import('application.modules.manageApps.components.ApkParser.*');
        $apk = new Parser($filename);
        $manifest = $apk->getManifest();

        return array(
            'package_name'=>$manifest->getPackageName(),
            'version'=>$manifest->getVersionName(),
            'min_sdk_level'=>$manifest->getMinSdkLevel(),
            'min_sdk_platform'=>$manifest->getMinSdk()->platform,
        );
    }

    /**
     * Save app package info
     */
    public function actionSavePackage()
    {
        if(isset($_POST['app_id'])) {
            $uploadDir = Yii::getPathOfAlias("webroot") . '/uploads/apps/files/' . $_POST['filesFolder'];
            $tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp';
            if (!is_dir($uploadDir))
                mkdir($uploadDir);

            $model = new AppPackages();
            $model->app_id = $_POST['app_id'];
            $model->create_date = time();
            $model->publish_date = time();
            $model->status='accepted';
            if ($_POST['platform'] == 'android') {
                $apkInfo = $this->apkParser($tempDir . DIRECTORY_SEPARATOR . $_POST['Apps']['file_name']);
                $model->version = $apkInfo['version'];
                $model->package_name = $apkInfo['package_name'];
                $model->file_name = $apkInfo['version'] . '-' . $apkInfo['package_name'] . '.' . pathinfo($_POST['Apps']['file_name'], PATHINFO_EXTENSION);
            } else {
                $model->version = $_POST['version'];
                $model->package_name = $_POST['package_name'];
                $model->file_name = $_POST['version'] . '-' . $_POST['package_name'] . '.' . pathinfo($_POST['Apps']['file_name'], PATHINFO_EXTENSION);
            }

            if ($model->save()) {
                $response = ['status' => true, 'fileName' => CHtml::encode($model->file_name)];
                rename($tempDir . DIRECTORY_SEPARATOR . $_POST['Apps']['file_name'], $uploadDir . DIRECTORY_SEPARATOR . $model->file_name);
                if ($_POST['platform'] == 'android') {
                    /* @var $app Apps */
                    $app = Apps::model()->findByPk($_POST['app_id']);
                    $app->setScenario('set_permissions');
                    $app->permissions = CJSON::encode($this->getPermissionsName($apkInfo['permissions']));
                    $app->save();
                }
            } else {
                $response = ['status' => false, 'message' => $model->getError('package_name')];
                unlink($tempDir . '/' . $_POST['Apps']['file_name']);
            }

            echo CJSON::encode($response);
            Yii::app()->end();
        }
    }

    public function actionImages($id)
    {
        $tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
        $uploadDir = Yii::getPathOfAlias("webroot") . '/uploads/apps/images/';
        if (isset($_POST['image'])) {
            $flag = true;
            foreach ($_POST['image'] as $image) {
                if (file_exists($tempDir . $image)) {
                    $model = new AppImages();
                    $model->app_id = (int)$id;
                    $model->image = $image;
                    rename($tempDir . $image, $uploadDir . $image);
                    if (!$model->save(false))
                        $flag = false;
                }
            }
            if ($flag)
                Yii::app()->user->setFlash('images-success', 'اطلاعات با موفقیت ثبت شد.');
            else
                Yii::app()->user->setFlash('images-failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        } else
            Yii::app()->user->setFlash('images-failed', 'تصاویر برنامه را آپلود کنید.');
        $this->redirect('update/' . $id . '/?step=3');
    }
}
