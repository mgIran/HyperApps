<?php

class PanelController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/panel';

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
            array('allow',
                'actions'=>array('account','index','uploadNationalCardImage','deleteNationalCardImage'),
                'roles'=>array('developer'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

	public function actionIndex()
	{
        Yii::app()->theme='market';
        $criteria=new CDbCriteria();
        $criteria->addCondition('developer_id = :user_id');
        $criteria->params=array(':user_id'=>Yii::app()->user->getId());
        $appsDataProvider=new CActiveDataProvider('Apps', array(
            'criteria'=>$criteria,
        ));
		$this->render('index', array(
            'appsDataProvider'=>$appsDataProvider,
        ));
	}

    /**
     * Update account
     */
    public function actionAccount()
    {
        Yii::app()->theme='market';
        Yii::import('application.modules.users.models.*');

        $detailsModel=UserDetails::model()->findByAttributes(array('user_id'=>Yii::app()->user->getId()));
        $devIdRequestModel=UserDevIdRequests::model()->findByAttributes(array('user_id'=>Yii::app()->user->getId()));
        if($detailsModel->developer_id=='' && is_null($devIdRequestModel))
            $devIdRequestModel=new UserDevIdRequests();

        $detailsModel->scenario='update_profile';

        if(isset($_POST['ajax']) && $_POST['ajax']==='change-developer-id-form')
            $this->performAjaxValidation($devIdRequestModel);
        else
            $this->performAjaxValidation($detailsModel);

        // Save developer profile
        if(isset($_POST['UserDetails']))
        {
            unset($_POST['UserDetails']['credit']);
            unset($_POST['UserDetails']['developer_id']);
            $detailsModel->attributes=$_POST['UserDetails'];
            $detailsModel->details_status='pending';
            if($detailsModel->save())
            {
                // Manage national card image
                $tmpDir = Yii::getPathOfAlias("webroot").'/uploads/temp/';
                $uploadDir = Yii::getPathOfAlias("webroot").'/uploads/users/national_cards/';
                $imager = new Imager();
                $imageInfo=$imager->getImageInfo($tmpDir.$detailsModel->national_card_image);
                if($imageInfo['width']>500 || $imageInfo['height']>500)
                    $imager->resize($tmpDir.$detailsModel->national_card_image, $uploadDir.$detailsModel->national_card_image, 500, 500);
                else
                    @copy($tmpDir.$detailsModel->national_card_image, $uploadDir.$detailsModel->national_card_image);
                @unlink($tmpDir.$detailsModel->national_card_image);

                Yii::app()->user->setFlash('success' , 'اطلاعات با موفقیت ثبت شد.');
                $this->refresh();
            }
            else
                Yii::app()->user->setFlash('fail' , 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }

        // Save the change request developerID
        if(isset($_POST['UserDevIdRequests']))
        {
            $devIdRequestModel->user_id=Yii::app()->user->getId();
            $devIdRequestModel->requested_id=$_POST['UserDevIdRequests']['requested_id'];
            if($devIdRequestModel->save())
            {
                Yii::app()->user->setFlash('success' , 'اطلاعات با موفقیت ثبت شد.');
                $this->refresh();
            }
            else
                Yii::app()->user->setFlash('fail' , 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }

        $nationalCardImageUrl=$this->createUrl('/uploads/users/national_cards');
        $nationalCardImagePath=Yii::getPathOfAlias('webroot').'/uploads/users/national_cards';
        $nationalCardImage=array();
        if($detailsModel->national_card_image!='')
            $nationalCardImage=array(
                array(
                    'name' => $detailsModel->national_card_image,
                    'src' => $nationalCardImageUrl.'/'.$detailsModel->national_card_image,
                    'size' => filesize($nationalCardImagePath.'/'.$detailsModel->national_card_image),
                    'serverName' => $detailsModel->national_card_image,
                ),
            );

        $this->render('account', array(
            'detailsModel'=>$detailsModel,
            'devIdRequestModel'=>$devIdRequestModel,
            'nationalCardImage'=>$nationalCardImage,
        ));
    }

    /**
     * Upload national card image
     */
    public function actionUploadNationalCardImage()
    {
        $tmpDir = Yii::getPathOfAlias("webroot").'/uploads/temp/';
        $uploadDir = Yii::getPathOfAlias("webroot").'/uploads/users/national_cards/';
        if (!is_dir($tmpDir))
            mkdir($tmpDir);
        if (!is_dir($uploadDir))
            mkdir($uploadDir);
        if (isset($_FILES)) {
            $file = $_FILES['national_card_image'];
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $file['name'] = Controller::generateRandomString(5) . time();
            while (file_exists($tmpDir . $file['name']))
                $file['name'] = Controller::generateRandomString(5) . time();
            $file['name'] = $file['name'] . '.' . $ext;
            if (move_uploaded_file($file['tmp_name'], $tmpDir . CHtml::encode($file['name'])))
                $response = ['state' => 'ok', 'fileName' => CHtml::encode($file['name'])];
            else
                $response = ['state' => 'error', 'msg' => 'فایل آپلود نشد.'];
        } else
            $response = ['state' => 'error', 'msg' => 'فایلی ارسال نشده است.'];
        echo CJSON::encode($response);
        Yii::app()->end();
    }

    /**
     * Delete national card image
     */
    public function actionDeleteNationalCardImage()
    {
        if (isset($_POST['fileName']) || isset($_POST['data']))
        {
            if(isset($_POST['fileName']))
                $fileName = $_POST['fileName'];
            $uploadDir = Yii::getPathOfAlias("webroot") . '/uploads/users/national_cards/';
            $tmpDir = Yii::getPathOfAlias("webroot").'/uploads/temp/';

            Yii::import('application.modules.users.models.*');

            $model = UserDetails::model()->findByAttributes(array('user_id'=>Yii::app()->user->getId()));
            $response = null;
            if (!empty($model->national_card_image))
            {
                //var_dump($uploadDir . $model->national_card_image);
                if (@unlink($uploadDir . $model->national_card_image))
                {
                    $response = ['state' => 'ok', 'msg' => 'حذف شد.'];

                    // DELETE IMAGE AND NULL FIELD

                    $model->national_card_image='';
                    $model->save();
                }
                else
                    $response = ['state' => 'error', 'msg' => 'مشکل ایجاد شده است'];
            }
            elseif(empty($model->national_card_image) && file_exists($tmpDir . $fileName))
            {
                if (@unlink($tmpDir . $fileName))
                    $response = ['state' => 'ok', 'msg' => 'حذف شد.'];
                else
                    $response = ['state' => 'error', 'msg' => 'مشکل ایجاد شده است'];
            }
            else
                $response = ['state' => 'error', 'msg' => 'مشکل ایجاد شده است'];
            echo CJSON::encode($response);
            Yii::app()->end();
        }
    }

    /**
     * Performs the AJAX validation.
     * @param Apps $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']))
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}