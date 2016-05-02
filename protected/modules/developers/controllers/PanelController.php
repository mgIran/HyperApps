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
                'actions'=>array('manageSettlement'),
                'roles'=>array('admin')
            ),
            array('allow',
                'actions'=>array('uploadNationalCardImage'),
                'users'=>array('@'),
            ),
            array('allow',
                'actions'=>array('signup'),
                'roles'=>array('user'),
            ),
            array('allow',
                'actions'=>array('account','index','settlement','sales'),
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
            unset($_POST['UserDetails']['details_status']);
            $detailsModel->attributes=$_POST['UserDetails'];
            $detailsModel->details_status='pending';
            if($detailsModel->save())
            {
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
                'name' => $detailsModel->national_card_image,
                'src' => $nationalCardImageUrl.'/'.$detailsModel->national_card_image,
                'size' => (file_exists($nationalCardImagePath.'/'.$detailsModel->national_card_image))?filesize($nationalCardImagePath.'/'.$detailsModel->national_card_image):0,
                'serverName' => $detailsModel->national_card_image,
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
        $uploadDir = Yii::getPathOfAlias("webroot").'/uploads/users/national_cards/';
        if (!is_dir(Yii::getPathOfAlias("webroot").'/uploads/users/'))
            mkdir(Yii::getPathOfAlias("webroot").'/uploads/users/');
        if (!is_dir($uploadDir))
            mkdir($uploadDir);
        if (isset($_FILES)) {
            Yii::import('application.modules.users.models.*');
            $model = UserDetails::model()->findByAttributes(array('user_id'=>Yii::app()->user->getId()));

            $file = $_FILES['national_card_image'];
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $file['name'] = Controller::generateRandomString(5) . time();
            $file['name'] = $file['name'].'.'.$ext;
            if(move_uploaded_file($file['tmp_name'], $uploadDir.CHtml::encode($file['name'])))
            {
                $response = ['state' => 'ok', 'fileName' => CHtml::encode($file['name'])];

                // Delete old image
                if(!empty($model->national_card_image))
                    @unlink($uploadDir.$model->national_card_image);

                $model->national_card_image=$file['name'];
                $model->scenario='upload_photo';
                $model->save();

                // Resize image
                $imager = new Imager();
                $imageInfo=$imager->getImageInfo($uploadDir.$model->national_card_image);
                if($imageInfo['width']>500 || $imageInfo['height']>500)
                    $imager->resize($uploadDir.$model->national_card_image, $uploadDir.$model->national_card_image, 500, 500);
            }
            else
                $response = ['state' => 'error', 'msg' => 'فایل آپلود نشد.'];
        } else
            $response = ['state' => 'error', 'msg' => 'فایلی ارسال نشده است.'];
        echo CJSON::encode($response);
        Yii::app()->end();
    }

    /**
     * Convert user account to developer
     */
    public function actionSignup()
    {
        Yii::app()->theme='market';
        $data=array();

        switch(Yii::app()->request->getQuery('step'))
        {
            case 'agreement':
                Yii::import('application.modules.pages.models.*');
                $data['agreementText']=Pages::model()->find('title=:title', array(':title'=>'قرارداد توسعه دهندگان'));
                break;

            case 'profile':
                Yii::import('application.modules.users.models.*');
                Yii::import('application.modules.setting.models.*');
                $data['detailsModel']=UserDetails::model()->findByAttributes(array('user_id'=>Yii::app()->user->getId()));
                $data['detailsModel']->scenario='update_profile';
                $minCredit=SiteSetting::model()->find('name=:name', array(':name'=>'min_credit'));

                if(is_null($data['detailsModel']->credit))
                    $data['detailsModel']->credit=0;

                if($data['detailsModel']->credit < $minCredit['value'])
                {
                    Yii::app()->user->setFlash('min_credit_fail' , 'برای ثبت نام به عنوان توسعه دهنده باید حداقل '.number_format($minCredit['value'], 0).' تومان اعتبار داشته باشید.');
                    $this->redirect($this->createUrl('/users/credit/buy'));
                }

                if(isset($_POST['ajax']) && $_POST['ajax']==='update-profile-form')
                    $this->performAjaxValidation($data['detailsModel']);

                // Save developer profile
                if(isset($_POST['UserDetails']))
                {
                    unset($_POST['UserDetails']['credit']);
                    unset($_POST['UserDetails']['developer_id']);
                    unset($_POST['UserDetails']['details_status']);
                    $data['detailsModel']->attributes=$_POST['UserDetails'];
                    $data['detailsModel']->details_status='pending';
                    if($data['detailsModel']->save())
                    {
                        $data['detailsModel']->user->role_id=2;
                        $data['detailsModel']->user->scenario='change_role';
                        $data['detailsModel']->user->save(false);
                        Yii::app()->user->setFlash('success' , 'اطلاعات با موفقیت ثبت شد.');
                        $this->redirect($this->createUrl('/developers/panel/signup/step/finish'));
                    }
                    else
                        Yii::app()->user->setFlash('fail' , 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
                }
                $nationalCardImageUrl=$this->createUrl('/uploads/users/national_cards');
                $nationalCardImagePath=Yii::getPathOfAlias('webroot').'/uploads/users/national_cards';
                $data['nationalCardImage']=array();
                if($data['detailsModel']->national_card_image!='')
                    $data['nationalCardImage']=array(
                        'name' => $data['detailsModel']->national_card_image,
                        'src' => $nationalCardImageUrl.'/'.$data['detailsModel']->national_card_image,
                        'size' => (file_exists($nationalCardImagePath.'/'.$data['detailsModel']->national_card_image))?filesize($nationalCardImagePath.'/'.$data['detailsModel']->national_card_image):0,
                        'serverName' => $data['detailsModel']->national_card_image,
                    );
                break;

            case 'finish':
                if(isset($_POST['goto_developer_panel']))
                {
                    Yii::app()->user->setState('roles', 'developer');
                    $this->redirect($this->createUrl('/developers/panel'));
                }
                Yii::import('application.modules.users.models.*');
                $data['userDetails']=UserDetails::model()->findByAttributes(array('user_id'=>Yii::app()->user->getId()));
                break;
        }

        $this->render('signup', array(
            'step'=>Yii::app()->request->getQuery('step'),
            'data'=>$data,
        ));
    }

    /**
     * Settlement
     */
    public function actionSettlement()
    {
        Yii::app()->theme='market';
        $this->layout='//layouts/panel';

        Yii::app()->getModule('users');
        Yii::app()->getModule('pages');
        $userDetailsModel=UserDetails::model()->findByAttributes(array('user_id'=>Yii::app()->user->getId()));
        $helpText=Pages::model()->findByPk(6);
        $userDetailsModel->setScenario('update-settlement');
        // Get history of settlements
        $criteria=new CDbCriteria();
        $criteria->addCondition('user_id=:user_id');
        $criteria->params=array(':user_id'=>Yii::app()->user->getId());
        $settlementHistory=new CActiveDataProvider('UserSettlement', array(
            'criteria'=>$criteria,
        ));

        $this->performAjaxValidation($userDetailsModel);

        if(isset($_POST['UserDetails'])) {
            $userDetailsModel->monthly_settlement=$_POST['UserDetails']['monthly_settlement'];
            if($_POST['UserDetails']['monthly_settlement']==1)
                $userDetailsModel->iban=$_POST['UserDetails']['iban'];
            else
                $userDetailsModel->iban=null;
            if($userDetailsModel->save())
                Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ثبت شد.');
            else
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است لطفا مجددا تلاش کنید.');
        }

        $this->render('settlement', array(
            'userDetailsModel'=>$userDetailsModel,
            'helpText'=>$helpText->summary,
            'settlementHistory'=>$settlementHistory,
        ));
    }

    /**
     * Report sales
     */
    public function actionSales()
    {
        Yii::app()->theme='market';
        $this->layout='//layouts/panel';

        // user's apps
        $criteria=new CDbCriteria();
        $criteria->addCondition('developer_id=:dev_id');
        $criteria->params=array(':dev_id'=>Yii::app()->user->getId());
        $apps=new CActiveDataProvider('Apps', array(
            'criteria'=>$criteria,
        ));

        $labels = $values = array();
        if(isset($_POST['show-chart'])) {
            $criteria = new CDbCriteria();
            $criteria->addCondition('date > :from_date');
            $criteria->addCondition('date < :to_date');
            $criteria->addCondition('app_id=:app_id');
            $criteria->params = array(
                ':from_date' => $_POST['from_date_altField'],
                ':to_date' => $_POST['to_date_altField'],
                ':app_id' => $_POST['app_id'],
            );
            $report = AppBuys::model()->findAll($criteria);
            if ($_POST['to_date_altField'] - $_POST['from_date_altField'] < (60 * 60 * 24 * 30)) {
                // show daily report
                $datesDiff = $_POST['to_date_altField'] - $_POST['from_date_altField'];
                $daysCount = ($datesDiff / (60 * 60 * 24));
                for ($i = 0; $i < $daysCount; $i++) {
                    $labels[] = JalaliDate::date('d F Y', $_POST['from_date_altField'] + (60 * 60 * (24 * $i)));
                    $count = 0;
                    foreach ($report as $model) {
                        if ($model->date >= $_POST['from_date_altField'] + (60 * 60 * (24 * $i)) and $model->date < $_POST['from_date_altField'] + (60 * 60 * (24 * ($i + 1))))
                            $count++;
                    }
                    $values[] = $count;
                }
            }
            else {
                // show monthly report
                $datesDiff = $_POST['to_date_altField'] - $_POST['from_date_altField'];
                $monthCount = ceil($datesDiff / (60 * 60 * 24 * 30));
                for ($i = 0; $i < $monthCount; $i++) {
                    $labels[] = JalaliDate::date('d F', $_POST['from_date_altField'] + (60 * 60 * 24 * (30 * $i))) . ' الی ' . JalaliDate::date('d F', $_POST['from_date_altField'] + (60 * 60 * 24 * (30 * ($i + 1))));
                    $count = 0;
                    foreach ($report as $model) {
                        if ($model->date >= $_POST['from_date_altField'] + (60 * 60 * 24 * (30 * $i)) and $model->date < $_POST['from_date_altField'] + (60 * 60 * 24 * (30 * ($i + 1))))
                            $count++;
                    }
                    $values[] = $count;
                }
            }
        }

        $this->render('sales',array(
            'apps'=>$apps,
            'labels'=>$labels,
            'values'=>$values,
        ));
    }

    /**
     * Manage settlement
     */
    public function actionManageSettlement()
    {
        Yii::app()->theme='abound';
        $this->layout='//layouts/column2';
        $criteria=new CDbCriteria();
        $criteria->select='SUM(amount) AS amount, date';
        $criteria->group='EXTRACT(DAY FROM FROM_UNIXTIME(date, "%Y %D %M %h:%i:%s %x"))';
        $settlementHistory=new CActiveDataProvider('UserSettlement', array(
            'criteria'=>$criteria,
        ));
        Yii::app()->getModule('setting');
        $setting=SiteSetting::model()->find('name=:name', array(':name'=>'min_credit'));
        $criteria=new CDbCriteria();
        $criteria->addCondition('monthly_settlement=1');
        $criteria->addCondition('credit>:credit');
        $criteria->params=array(':credit'=>$setting->value);
        $settlementRequiredUsers=new CActiveDataProvider('UserDetails', array(
            'criteria'=>$criteria,
        ));

        if(isset($_POST['ajax']) and isset($_POST['uid'])) {
            $userDetails=UserDetails::model()->findByAttributes(array('user_id'=>$_POST['uid']));
            $model=new UserSettlement();
            $model->user_id=$userDetails->user_id;
            $model->amount=$userDetails->getSettlementAmount();
            $model->date=time();
            $model->iban=$userDetails->iban;
            if($model->save()) {
                $userDetails->credit=$userDetails->credit-$userDetails->getSettlementAmount();
                $userDetails->save();
                echo CJSON::encode(array(
                    'status' => true
                ));
            }
            else
                echo CJSON::encode(array(
                    'status'=>false
                ));
            Yii::app()->end();
        }

        $this->render('manage_settlement', array(
            'settlementHistory'=>$settlementHistory,
            'settlementRequiredUsers'=>$settlementRequiredUsers,
        ));
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