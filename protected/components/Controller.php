<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    /**
     * @var string the default layout for the controller views. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public $town = null;
    public $place = null;
    public $description;
    public $keywords;
    public $siteName;
    public $pageTitle;
    public $sideRender = null;
    public $categories;
    public $platform;
    public $userDetails;
    public $userNotifications;

    protected function beforeAction($action)
    {
        if($this->id==='site' and $action->id==='index')
        {
            $queryPlatform=Yii::app()->request->getQuery('platform');
            if(is_null($queryPlatform))
                $queryPlatform='android';
            $platform=AppPlatforms::model()->findByAttributes(array('name'=>$queryPlatform));
            $this->platform=$platform->id;
            Yii::app()->user->setState('platform', $platform->id);
            Yii::app()->user->setState('platformName', $queryPlatform);
        }
        else
            $this->platform=Yii::app()->user->getState('platform');

        Yii::import("users.models.*");
        $this->userDetails = UserDetails::model()->findByPk(Yii::app()->user->getId());
        $this->userNotifications=UserNotifications::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->getId(),'seen'=>'0'));
        return true;
    }

    public function beforeRender($view){
        $this->description = Yii::app()->db->createCommand()
            ->select('value')
            ->from('ym_site_setting')
            ->where('name = "site_description"')
            ->queryScalar();
        $this->keywords = Yii::app()->db->createCommand()
            ->select('value')
            ->from('ym_site_setting')
            ->where('name = "keywords"')
            ->queryScalar();
        $this->siteName = Yii::app()->db->createCommand()
            ->select('value')
            ->from('ym_site_setting')
            ->where('name = "site_title"')
            ->queryScalar();
        $this->pageTitle = Yii::app()->db->createCommand()
            ->select('value')
            ->from('ym_site_setting')
            ->where('name = "default_title"')
            ->queryScalar();
        $this->categories=array(
            'programs'=>AppCategories::model()->findAll('parent_id=1'),
            'games'=>AppCategories::model()->findAll('parent_id=2'),
            'educations'=>AppCategories::model()->findAll('parent_id=3'),
        );
        return true;
    }

    public static function createAdminMenu()
    {
        if(Yii::app()->user->type === 'admin')
            return array(
                array(
                    'label' => 'پیشخوان' ,
                    'url' => array('/admins/dashboard')
                ) ,
                array(
                    'label' => 'برنامه ها<span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,
                    'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'بخش اندروید' ,'url' => Yii::app()->createUrl('/manageApps/android/admin/')) ,
                        array('label' => 'بخش آی او اس' ,'url' => Yii::app()->createUrl('/manageApps/iOS/admin/')) ,
                        array('label' => 'بخش ویندوز فون' ,'url' => Yii::app()->createUrl('/manageApps/windowsPhone/admin/')) ,
                    )
                ) ,
                array(
                    'label' => 'دسته بندی برنامه ها<span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,
                    'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'مدیریت' ,'url' => Yii::app()->createUrl('/appCategories/admin/')) ,
                        array('label' => 'افزودن' ,'url' => Yii::app()->createUrl('/appCategories/create/')) ,
                    )
                ) ,
                array(
                    'label' => 'امور مالی<span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,
                    'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'تسویه حساب','url' => Yii::app()->createUrl('/developers/panel/manageSettlement')) ,
                        array('label' => 'گزارش فروش' ,'url' => Yii::app()->createUrl('/apps/reportSales')) ,
                    )
                ) ,
                array(
                    'label' => 'صفحات متنی' ,
                    'url' => Yii::app()->createUrl('/pages/manage/admin/?slug=base'),
                ) ,
                array(
                    'label' => 'مدیران <span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'مدیریت' ,'url' => Yii::app()->createUrl('/admins/manage')) ,
                        array('label' => 'افزودن' ,'url' => Yii::app()->createUrl('/admins/manage/create')) ,
                    )
                ) ,
                array(
                    'label' => 'کاربران <span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,
                    'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'مدیریت' ,'url' => Yii::app()->createUrl('/users/manage')) ,
                    )
                ) ,
                array(
                    'label' => 'تنظیمات<span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,
                    'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'عمومی' ,'url' => Yii::app()->createUrl('/setting/siteSettingManage/changeSetting')) ,
                    )
                ) ,
                array(
                    'label' => 'ورود' ,
                    'url' => array('/admins/login') ,
                    'visible' => Yii::app()->user->isGuest
                ) ,
                array(
                    'label' => 'خروج' ,
                    'url' => array('/admins/login/logout') ,
                    'visible' => !Yii::app()->user->isGuest) ,
            );
        else
            return array();
    }

    /**
     * @param $model
     * @return string
     */
    public function implodeErrors($model)
    {
        $errors = '';
        foreach($model->getErrors() as $err){
            $errors .= implode('<br>' ,$err) . '<br>';
        }
        return $errors;
    }

    public static function generateRandomString($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for($i = 0;$i < $length;$i++){
            $randomString .= $characters[rand(0 ,$charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Converts latin numbers to farsi script
     */
    public static function parseNumbers($matches)
    {
        $farsi_array = array('۰' ,'۱' ,'۲' ,'۳' ,'۴' ,'۵' ,'۶' ,'۷' ,'۸' ,'۹');
        $english_array = array('0' ,'1' ,'2' ,'3' ,'4' ,'5' ,'6' ,'7' ,'8' ,'9');

        return str_replace($english_array ,$farsi_array ,$matches);
    }

    public static function allCategories()
    {
        Yii::import('advertises.models.AdvertiseCategories');
        return AdvertiseCategories::model()->findAll('parent IS NULL order by name ASC');
    }

    public static function fileSize($file){
        if(file_exists($file)) {
            $size = filesize($file);
            if($size < 1024)
                return $size.' Byte';
            elseif($size < 1024*1024){
                $size = (float)$size/1024;
                return number_format($size,1). ' KB';
            }
            elseif($size < 1024*1024*1024){
                $size = (float)$size/(1024*1024);
                return number_format($size,1). ' MB';
            }else
            {
                $size = (float)$size/(1024*1024*1024);
                return number_format($size,1). ' MB';
            }
        }
        return 0;
    }

    public function saveInCookie($catID)
    {
        $cookie=Yii::app()->request->cookies->contains('VC')?Yii::app()->request->cookies['VC']:null;

        if(is_null($cookie)) {
            $cats=base64_encode(CJSON::encode(array($catID)));
            $newCookie = new CHttpCookie('VC', $cats);
            $newCookie->domain = '';
            $newCookie->expire = time()+(60*60*24*365);
            $newCookie->path='/';
            $newCookie->secure=false;
            $newCookie->httpOnly=false;
            Yii::app()->request->cookies['VC'] = $newCookie;
        }
        else {
            $cats=CJSON::decode(base64_decode($cookie->value));
            if(!in_array($catID, $cats)) {
                array_push($cats, $catID);
                $cats=base64_encode(CJSON::encode($cats));
                Yii::app()->request->cookies['VC'] = new CHttpCookie('VC', $cats);
            }
        }
    }

    public function createLog($message, $userID)
    {
        Yii::app()->getModule('users');
        $model=new UserNotifications();
        $model->user_id=$userID;
        $model->message=$message;
        $model->seen=0;
        $model->date=time();
        $model->save();
    }
}