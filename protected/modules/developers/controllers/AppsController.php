<?php

class AppsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';
	private $filesFolder = null;
	public $formats = null;


	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
			array(
				'allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions' => array('create', 'update', 'delete', 'uploadImage', 'deleteImage', 'upload', 'deleteUpload', 'uploadFile', 'deleteUploadFile', 'images', 'savePackage'),
				'roles' => array('developer'),
			),
			array(
				'deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
    {
        if (Yii::app()->user->isGuest || Yii::app()->user->type != 'admin') {
            $user = UserDetails::model()->findByPk(Yii::app()->user->getId());
            if ($user->details_status == 'refused') {
                Yii::app()->user->setFlash('failed', 'اطلاعات قرارداد شما رد شده است و نمیتوانید برنامه ثبت کنید. در صورت نیاز نسبت به تغییر اطلاعات خود اقدام کنید.');
                $this->redirect(array('/developers/panel/account'));
            } elseif ($user->details_status == 'pending') {
                Yii::app()->user->setFlash('warning', 'اطلاعات قرارداد شما در انتظار تایید می باشد،لطفا پس از تایید اطلاعات مجددا تلاش کنید.');
                $this->redirect(array('/developers/panel/account'));
            }
            if (!$user->developer_id) {
                $devIdRequestModel = UserDevIdRequests::model()->findByAttributes(array('user_id' => Yii::app()->user->getId()));
                if ($devIdRequestModel)
                    Yii::app()->user->setFlash('warning', 'درخواست شما برای شناسه توسعه دهنده در انتظار تایید می باشد، لطفا شکیبا باشید.');
                else
                    Yii::app()->user->setFlash('failed', 'شناسه توسعه دهنده تنظیم نشده است. برای ثبت برنامه شناسه توسعه دهنده الزامیست.');
                $this->redirect(array('/developers/panel/account'));
            }

            Yii::app()->theme = 'market';
            $this->layout = '//layouts/panel';
            $model = new Apps;

            // Save step 1
            if (isset($_POST['platform_id']) && !empty($_POST['platform_id'])) {
                $model->platform_id = $_POST['platform_id'];
				$model->developer_id=Yii::app()->user->getId();
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ثبت شد.');
                    $this->redirect('update/' . $model->id.'?new=1');
                } else
                    Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');

            } elseif (isset($_POST['platform_id']) && empty($_POST['platform_id']))
                $model->addError("platform_id", 'لطفا یک گزینه را انتخاب کنید');

            $this->render('create', array(
                'model' => $model,
            ));
        } else {
            Yii::app()->user->setFlash('failed', 'از طریق مدیریت اقدام کنید');
            $this->redirect(array('/admins/dashboard'));
        }
    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$step = 1;
		Yii::app()->theme = 'market';
		$this->layout = '//layouts/panel';
		$model = $this->loadModel($id);
		if($model->developer_id!=Yii::app()->user->getId()) {
			Yii::app()->user->setFlash('images-failed', 'شما اجازه دسترسی به این صفحه را ندارید.');
			$this->redirect($this->createUrl('/developers/panel'));
		}
		$tmpDIR = Yii::getPathOfAlias("webroot").'/uploads/temp/';
		if(!is_dir($tmpDIR))
			mkdir($tmpDIR);
		$tmpUrl = Yii::app()->createAbsoluteUrl('/uploads/temp/');
		$appIconsDIR = Yii::getPathOfAlias("webroot").'/uploads/apps/icons/';
		$appImagesDIR = Yii::getPathOfAlias("webroot").'/uploads/apps/images/';
		$appIconsUrl = Yii::app()->createAbsoluteUrl('/uploads/apps/icons');
		$appImagesUrl = Yii::app()->createAbsoluteUrl('/uploads/apps/images');
		if($model->platform) {
			$platform = $model->platform;
			$formats = explode(',', $platform->file_types);
			if(count($formats) > 1) {
				foreach($formats as $key => $format) {
					$format = '.'.trim($format);
					$formats[$key] = $format;
				}
				$this->formats = implode(',', $formats);
			} else
				$this->formats = '.'.trim($formats[0]);

			$this->filesFolder = $platform->name;
			$appFilesDIR = Yii::getPathOfAlias("webroot")."/uploads/apps/files/{$this->filesFolder}/";
			if(!is_dir($appFilesDIR))
				mkdir($appFilesDIR);
			$appFilesUrl = Yii::app()->createAbsoluteUrl("/uploads/apps/files/{$this->filesFolder}");
		} else
			$this->redirect(array('create'));

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		$icon = array();
		if(!is_null($model->icon))
			$icon = array(
				'name' => $model->icon,
				'src' => $appIconsUrl.'/'.$model->icon,
				'size' => filesize($appIconsDIR.$model->icon),
				'serverName' => $model->icon
			);
		$images = array();
		if($model->images)
			foreach($model->images as $image)
				if(file_exists($appImagesDIR.$image->image))
					$images[] = array(
						'name' => $image->image,
						'src' => $appImagesUrl.'/'.$image->image,
						'size' => filesize($appImagesDIR.$image->image),
						'serverName' => $image->image,
					);

        if(isset($_POST['packages-submit'])){
            if(empty($model->packages))
                Yii::app()->user->setFlash('failed', 'بسته ای تعریف نشده است.');
            else
                $this->redirect($this->createUrl('/developers/apps/update/'.$model->id.'?step=2'));
        }

		if(isset($_POST['Apps'])) {
			$iconFlag = false;
			if(isset($_POST['Apps']['icon']) && file_exists($tmpDIR.$_POST['Apps']['icon']) && $_POST['Apps']['icon'] != $model->icon) {
				$file = $_POST['Apps']['icon'];
				$icon = array(array('name' => $file, 'src' => $tmpUrl.'/'.$file, 'size' => filesize($tmpDIR.$file), 'serverName' => $file,));
				$iconFlag = true;
			}
			$model->attributes = $_POST['Apps'];
			if(count($_POST['Apps']['permissions']) > 0 && !empty($_POST['Apps']['permissions'][0])) {
				foreach($_POST['Apps']['permissions'] as $key => $permission) {
					if(empty($permission))
						unset($_POST['Apps']['permissions'][$key]);
				}
				$model->permissions = CJSON::encode($_POST['Apps']['permissions']);
			} else
				$model->permissions = null;

			$model->confirm = 'pending';

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
				if($iconFlag) {
					$thumbnail = new Imager();
					$thumbnail->createThumbnail($tmpDIR.$model->icon, 150, 150, false, $appIconsDIR.$model->icon);
					unlink($tmpDIR.$model->icon);
				}
				Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ویرایش شد.');
				$this->redirect(array('/developers/apps/update/' . $model->id. '?step=3'));
			} else {
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
			}
		}

		if(isset($_GET['step']) && !empty($_GET['step']))
			$step = (int)$_GET['step'];

		$criteria=new CDbCriteria();
		$criteria->addCondition('app_id=:app_id');
		$criteria->params=array(
			':app_id'=>$id,
		);
		$packagesDataProvider=new CActiveDataProvider('AppPackages', array('criteria'=>$criteria));

		Yii::app()->getModule('setting');
		$this->render('update', array(
			'model' => $model,
			'imageModel' => new AppImages(),
			'images' => $images,
			'icon' => $icon,
			'packagesDataProvider' => $packagesDataProvider,
			'step' => $step,
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
		Apps::model()->updateByPk($id,array('deleted' => 1));

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/developers/panel'));
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
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Apps $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'apps-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


	/**
	 * Upload And Delete App File and Icon Functions
	 */
	public function actionUpload()
	{
		$tempDir = Yii::getPathOfAlias("webroot").'/uploads/temp';

		if(!is_dir($tempDir))
			mkdir($tempDir);
		if(isset($_FILES)) {
			$file = $_FILES['icon'];
			$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
			$file['name'] = Controller::generateRandomString(5).time();
			while(file_exists($tempDir.DIRECTORY_SEPARATOR.$file['name']))
				$file['name'] = Controller::generateRandomString(5).time();
			$file['name'] = $file['name'].'.'.$ext;
			if(move_uploaded_file($file['tmp_name'], $tempDir.DIRECTORY_SEPARATOR.CHtml::encode($file['name'])))
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
		$Dir = Yii::getPathOfAlias("webroot").'/uploads/apps/icons/';

		if(isset($_POST['fileName'])) {

			$fileName = $_POST['fileName'];

			$tempDir = Yii::getPathOfAlias("webroot").'/uploads/temp/';

			$model = Apps::model()->findByAttributes(array('icon' => $fileName));
			if($model) {
				if(@unlink($Dir.$model->icon)) {
					$model->updateByPk($model->id, array('icon' => null));
					$response = ['state' => 'ok', 'msg' => $this->implodeErrors($model)];
				} else
					$response = ['state' => 'error', 'msg' => 'مشکل ایجاد شده است'];
			} else {
				@unlink($tempDir.$fileName);
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

	/**
	 * Upload app images
	 */
	public function actionUploadImage()
	{
		$uploadDir = Yii::getPathOfAlias("webroot").'/uploads/temp';
		if(!is_dir($uploadDir))
			mkdir($uploadDir);
		if(isset($_FILES)) {
			$file = $_FILES['image'];
			$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
			$file['name'] = Controller::generateRandomString(5).time();
			while(file_exists($uploadDir.DIRECTORY_SEPARATOR.$file['name'].'.'.$ext))
				$file['name'] = Controller::generateRandomString(5).time();
			$file['name'] = $file['name'].'.'.$ext;
			if(move_uploaded_file($file['tmp_name'], $uploadDir.DIRECTORY_SEPARATOR.CHtml::encode($file['name']))) {
				$response = ['state' => 'ok', 'fileName' => CHtml::encode($file['name'])];
			} else
				$response = ['state' => 'error', 'msg' => 'فایل آپلود نشد.'];
		} else
			$response = ['state' => 'error', 'msg' => 'فایلی ارسال نشده است.'];
		echo CJSON::encode($response);
		Yii::app()->end();
	}

	/**
	 * Delete app images
	 */
	public function actionDeleteImage()
	{
		if(isset($_POST['fileName'])) {

			$fileName = $_POST['fileName'];

			$uploadDir = Yii::getPathOfAlias("webroot").'/uploads/apps/images/';
			$tempDir = Yii::getPathOfAlias("webroot").'/uploads/temp/';

			$model = AppImages::model()->findByAttributes(array('image' => $fileName));
			if($model) {
				if(unlink($uploadDir.$model->image)) {
					$model->delete();
					$response = ['state' => 'ok', 'msg' => $this->implodeErrors($model)];
				} else
					$response = ['state' => 'error', 'msg' => 'مشکل ایجاد شده است'];
			} else {
				@unlink($tempDir.$fileName);
				$response = ['state' => 'ok', 'msg' => 'حذف شد.'];
			}
			echo CJSON::encode($response);
			Yii::app()->end();
		}
	}

	public function actionImages($id)
	{
		$tempDir = Yii::getPathOfAlias("webroot").'/uploads/temp/';
		$uploadDir = Yii::getPathOfAlias("webroot").'/uploads/apps/images/';
		if(isset($_POST['AppImages']['image'])) {
			$flag = true;
			foreach ($_POST['AppImages']['image'] as $image) {
				if (file_exists($tempDir . $image)) {
					$model = new AppImages();
					$model->app_id = (int)$id;
					$model->image = $image;
					rename($tempDir . $image, $uploadDir . $image);
					if (!$model->save(false))
						$flag = false;
				}
			}
			if ($flag) {
				Yii::app()->user->setFlash('images-success', 'اطلاعات با موفقیت ثبت شد.');
				$this->redirect($this->createUrl('/developers/panel'));
			}
			else
				Yii::app()->user->setFlash('images-failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		} else
			Yii::app()->user->setFlash('images-failed', 'تصاویر برنامه را آپلود کنید.');
		$this->redirect('update/'.$id.'/?step=2');
	}

	/**
	 * Return APK file info
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
			$model->for = $_POST['for'];
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
			} else {
				$response = ['status' => false, 'message' => $model->getError('package_name')];
				unlink($tempDir . '/' . $_POST['Apps']['file_name']);
			}

			echo CJSON::encode($response);
			Yii::app()->end();
		}
    }
}