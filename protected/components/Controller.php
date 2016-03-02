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
                    'label' => 'نرم افزار ها<span class="caret"></span>' ,
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
                    'label' => 'صفحات متنی<span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,
                    'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'صفحات اصلی سایت' ,'url' => Yii::app()->createUrl('/pages/manage/admin/?slug=base')) ,
                        array('label' => 'قوانین' ,'url' => Yii::app()->createUrl('/pages/manage/update/5?slug=rules')) ,
                        array('label' => 'صفحات راهنما' ,'url' => Yii::app()->createUrl('/pages/manage/admin/?slug=guide')) ,
                        array('label' => 'صفحات آزاد' ,'url' => Yii::app()->createUrl('/pages/manage/admin/')) ,
                    )
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
                        //array( 'label' => 'افزودن', 'url' => Yii::app()->createUrl( '/users/manage/create' ) ),
                    )
                ) ,
                array(
                    'label' => 'مکان ها <span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,
                    'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'مدیریت استان ها' ,'url' => Yii::app()->createUrl('/places/towns/admin')) ,
                        array('label' => 'مدیریت شهر ها' ,'url' => Yii::app()->createUrl('/places/places/admin')) ,
                        array('label' => 'افزودن استان' ,'url' => Yii::app()->createUrl('/places/towns/create')) ,
                        array('label' => 'افزودن شهر' ,'url' => Yii::app()->createUrl('/places/places/create')) ,
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
                /*array( 'label' => 'My Account <span class="caret"></span>', 'url' => '#', 'itemOptions' => array( 'class' => 'dropdown', 'tabindex' => "-1" ), 'linkOptions' => array( 'class' => 'dropdown-toggle', 'data-toggle' => "dropdown" ),
                    'items' => array(
                        array( 'label' => 'My Messages <span class="badge badge-warning pull-right">26</span>', 'url' => '#' ),
                        array( 'label' => 'My Tasks <span class="badge badge-important pull-right">112</span>', 'url' => '#' ),
                        array( 'label' => 'My Invoices <span class="badge badge-info pull-right">12</span>', 'url' => '#' ),
                        array( 'label' => 'Separated link', 'url' => '#' ),
                        array( 'label' => 'One more separated link', 'url' => '#' ),
                    ) ),*/
            );
        elseif(Yii::app()->user->type === 'validator')
            return array(
                array(
                    'label' => 'پیشخوان' ,
                    'url' => array('/admins/dashboard')
                ) ,
                array(
                    'label' => 'آگهی ها <span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,
                    'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'مدیریت آگهی ها' ,'url' => Yii::app()->createUrl('/advertises/manage/admin')) ,
                        array('label' => 'افزودن آگهی' ,'url' => Yii::app()->createUrl('/advertises/manage/create')) ,
                        array('label' => 'مدیریت دسته بندی های آگهی' ,'url' => Yii::app()->createUrl('/advertises/categories/admin')) ,
                    )
                ) ,
                array(
                    'label' => 'صفحات متنی<span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,
                    'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'صفحات اصلی سایت' ,'url' => Yii::app()->createUrl('/pages/manage/admin/?slug=base')) ,
                        array('label' => 'قوانین' ,'url' => Yii::app()->createUrl('/pages/manage/update/5?slug=rules')) ,
                        array('label' => 'صفحات راهنما' ,'url' => Yii::app()->createUrl('/pages/manage/admin/?slug=guide')) ,
                        array('label' => 'صفحات آزاد' ,'url' => Yii::app()->createUrl('/pages/manage/admin/')) ,
                    )
                ) ,
                array(
                    'label' => 'کاربران <span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,
                    'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'مدیریت' ,'url' => Yii::app()->createUrl('/users/manage')) ,
                        //array( 'label' => 'افزودن', 'url' => Yii::app()->createUrl( '/users/manage/create' ) ),
                    )
                ) ,
                array(
                    'label' => 'مکان ها <span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,
                    'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'مدیریت استان ها' ,'url' => Yii::app()->createUrl('/places/towns/admin')) ,
                        array('label' => 'مدیریت شهر ها' ,'url' => Yii::app()->createUrl('/places/places/admin')) ,
                        array('label' => 'افزودن استان' ,'url' => Yii::app()->createUrl('/places/towns/create')) ,
                        array('label' => 'افزودن شهر' ,'url' => Yii::app()->createUrl('/places/places/create')) ,
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
                /*array( 'label' => 'My Account <span class="caret"></span>', 'url' => '#', 'itemOptions' => array( 'class' => 'dropdown', 'tabindex' => "-1" ), 'linkOptions' => array( 'class' => 'dropdown-toggle', 'data-toggle' => "dropdown" ),
                    'items' => array(
                        array( 'label' => 'My Messages <span class="badge badge-warning pull-right">26</span>', 'url' => '#' ),
                        array( 'label' => 'My Tasks <span class="badge badge-important pull-right">112</span>', 'url' => '#' ),
                        array( 'label' => 'My Invoices <span class="badge badge-info pull-right">12</span>', 'url' => '#' ),
                        array( 'label' => 'Separated link', 'url' => '#' ),
                        array( 'label' => 'One more separated link', 'url' => '#' ),
                    ) ),*/
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

}