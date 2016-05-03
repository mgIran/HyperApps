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
				array(
						'allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions' => array('create', 'update', 'delete', 'uploadImage', 'deleteImage', 'upload', 'deleteUpload', 'uploadFile', 'deleteUploadFile', 'images'),
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
		if(Yii::app()->user->isGuest || Yii::app()->user->type != 'admin') {
			$step = 1;
			$tmpDIR = Yii::getPathOfAlias("webroot").'/uploads/temp/';
			if(!is_dir($tmpDIR))
				mkdir($tmpDIR);
			$tmpUrl = Yii::app()->createAbsoluteUrl('/uploads/temp/');

			$appIconsDIR = Yii::getPathOfAlias("webroot").'/uploads/apps/icons/';

			Yii::app()->theme = 'market';
			$this->layout = '//layouts/panel';
			$model = new Apps;
			$app = array();
			$icon = array();
			// Step 1
			if(isset($_POST['platform_id']) && !empty($_POST['platform_id'])) {
				$model->platform_id = (int)$_POST['platform_id'];
				$platform = AppPlatforms::model()->findByPk($model->platform_id);
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
				if(!is_dir(Yii::getPathOfAlias("webroot")."/uploads/apps/files/{$this->filesFolder}/"))
					mkdir(Yii::getPathOfAlias("webroot")."/uploads/apps/files/{$this->filesFolder}/");
				$step = 2;
			} elseif(isset($_POST['platform_id']) && empty($_POST['platform_id'])) {
				$model->addError("platform_id", 'لطفا یک گزینه را انتخاب کنید');
			}


			$this->performAjaxValidation($model);

			// Step 2
			if(isset($_POST['Apps'])) {
				$step = 2;
				$model->attributes = $_POST['Apps'];
				if($model->platform_id) {
					$platform = AppPlatforms::model()->findByPk($model->platform_id);
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
					if(!is_dir(Yii::getPathOfAlias("webroot")."/uploads/apps/files/{$this->filesFolder}/"))
						mkdir(Yii::getPathOfAlias("webroot")."/uploads/apps/files/{$this->filesFolder}/");
					$appFilesDIR = Yii::getPathOfAlias("webroot")."/uploads/apps/files/{$this->filesFolder}/";
				}
				if(isset($_POST['Apps']['file_name'])) {
					$file = $_POST['Apps']['file_name'];
					$app = array(
							array(
									'name' => $file,
									'src' => $tmpUrl.'/'.$file,
									'size' => filesize($tmpDIR.$file),
									'serverName' => $file,
							)
					);
					$model->size = filesize($tmpDIR.$model->file_name);
				}

				if(isset($_POST['Apps']['icon'])) {
					$file = $_POST['Apps']['icon'];
					$icon = array(
							array(
									'name' => $file,
									'src' => $tmpUrl.'/'.$file,
									'size' => filesize($tmpDIR.$file),
									'serverName' => $file,
							)
					);
				}
				if(count($_POST['Apps']['permissions']) > 0 && !empty($_POST['Apps']['permissions'][0])) {
					foreach($_POST['Apps']['permissions'] as $key => $permission) {
						if(empty($permission))
							unset($_POST['Apps']['permissions'][$key]);
					}
					$model->permissions = CJSON::encode($_POST['Apps']['permissions']);
				} else
					$model->permissions = null;
				$model->developer_id = Yii::app()->user->getId();
				if($model->save()) {
					if($model->file_name) {
						rename($tmpDIR.$model->file_name, $appFilesDIR.$model->file_name);
					}
					if($model->icon) {
						$thumbnail = new Imager();
						$thumbnail->createThumbnail($tmpDIR.$model->icon, 150, 150, false, $appIconsDIR.$model->icon);
						@unlink($tmpDIR.$model->icon);
					}
					Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ثبت شد.');
					$this->redirect('update/'.$model->id.'/?step=2');
				} else
					Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
			}

			Yii::app()->getModule('setting');

			$this->render('create', array(
				'model' => $model,
				'icon' => $icon,
				'app' => $app,
				'images' => array(),
				'step' => $step,
				'tax'=>SiteSetting::model()->findByAttributes(array('name'=>'tax'))->value,
				'commission'=>SiteSetting::model()->findByAttributes(array('name'=>'commission'))->value,
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
		$step = 2;
		Yii::app()->theme = 'market';
		$this->layout = '//layouts/panel';
		$model = $this->loadModel($id);
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
			$appFilesUrl = Yii::app()->createAbsoluteUrl("/uploads/apps/files/{$this->filesFolder}");
		} else
			$this->redirect(array('create'));

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		$icon = array();
		if(file_exists($appIconsDIR.$model->icon))
			$icon = array(
					'name' => $model->icon,
					'src' => $appIconsUrl.'/'.$model->icon,
					'size' => filesize($appIconsDIR.$model->icon),
					'serverName' => $model->icon
			);
		$app = array();
		if(file_exists($appFilesDIR.$model->file_name))
			$app = array(
					'name' => $model->file_name,
					'src' => $appFilesUrl.'/'.$model->file_name,
					'size' => filesize($appFilesDIR.$model->file_name),
					'serverName' => $model->file_name
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
		if(isset($_POST['Apps'])) {
			$fileFlag = false;
			$iconFlag = false;
			if(isset($_POST['Apps']['file_name']) && $_POST['Apps']['file_name'] != $model->file_name) {
				$file = $_POST['Apps']['file_name'];
				$app = array(array('name' => $file, 'src' => $tmpUrl.'/'.$file, 'size' => filesize($tmpDIR.$file), 'serverName' => $file,));
				$fileFlag = true;
				$model->size = filesize($tmpDIR.$model->file_name);
			}
			if(isset($_POST['Apps']['icon']) && $_POST['Apps']['icon'] != $model->icon) {
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

			if($model->save()) {
				if($fileFlag) {
					rename($tmpDIR.$model->file_name, $appFilesDIR.$model->file_name);
				}
				if($iconFlag) {
					$thumbnail = new Imager();
					$thumbnail->createThumbnail($tmpDIR.$model->icon, 150, 150, false, $appIconsDIR.$model->icon);
					unlink($tmpDIR.$model->icon);
				}
				Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت وایریش شد.');
				$this->redirect(array('/developers/apps/update/' . $model->id. '?step=1'));
			} else {
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
			}
		}
		$this->render('update', array(
				'model' => $model,
				'imageModel' => new AppImages(),
				'images' => $images,
				'app' => $app,
				'icon' => $icon,
				'step' => $step
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
		if(isset($_FILES['file_name'])) {
			$tempDir = Yii::getPathOfAlias("webroot").'/uploads/temp';
			if(!is_dir($tempDir))
				mkdir($tempDir);
			if(isset($_FILES)) {
				$file = $_FILES['file_name'];
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
	}

	public function actionDeleteUploadFile()
	{
		$data = CJSON::decode($_POST['data']);
		$this->filesFolder = $data['filesFolder'];
		$Dir = Yii::getPathOfAlias("webroot")."/uploads/apps/files/{$this->filesFolder}/";

		if(isset($_POST['fileName'])) {

			$fileName = $_POST['fileName'];

			$tempDir = Yii::getPathOfAlias("webroot").'/uploads/temp/';

			$model = Apps::model()->findByAttributes(array('file_name' => $fileName));
			if($model) {
				if(unlink($Dir.$model->file_name)) {
					$model->updateByPk($model->id, array('file_name' => null));
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
			foreach($_POST['AppImages']['image'] as $image) {
				$model = new AppImages();
				$model->app_id = (int)$id;
				$model->image = $image;
				rename($tempDir.$image, $uploadDir.$image);
				if(!$model->save(false))
					$flag = false;
			}
			if($flag)
				Yii::app()->user->setFlash('images-success', 'اطلاعات با موفقیت ثبت شد.');
			else
				Yii::app()->user->setFlash('images-failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		} else
			Yii::app()->user->setFlash('images-failed', 'تصاویر برنامه را آپلود کنید.');
		$this->redirect('update/'.$id.'/?step=2');
	}
}