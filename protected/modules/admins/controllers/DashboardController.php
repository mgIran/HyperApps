<?php

class DashboardController extends Controller
{

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
        $adminRoles = AdminRoles::model()->findAll(array(
            'select' => 'role'
        ));
        $adminRoles = CHtml::listData($adminRoles,'role','role');
        return array(
            array('allow',  // allow all users to perform 'index' and 'views' actions
                'actions'=>array('index'),
                'roles' => $adminRoles,
            ),
            array('deny',  // deny all users
                'actions'=>array('index'),
                'users'=>array('*'),
            ),
        );
    }

	public function actionIndex()
    {
        Yii::app()->getModule('users');

        $criteria=new CDbCriteria();
        $criteria->addCondition('confirm=:confirm');
        $criteria->addCondition('deleted=:deleted');
        $criteria->addCondition('title!=""');
        $criteria->params=array(':confirm'=>'pending',':deleted'=>'0');
        $newestPrograms=new CActiveDataProvider('Apps', array(
            'criteria'=>$criteria,
        ));

        $criteria=new CDbCriteria();
        $criteria->with='user';
        $criteria->addCondition('user.role_id=2');
        $criteria->addCondition('user.status=:userStatus');
        $criteria->addCondition('details_status=:status');
        $criteria->params=array(':status'=>'pending',':userStatus'=>'active');
        $newestDevelopers=new CActiveDataProvider('UserDetails', array(
            'criteria'=>$criteria,
        ));

        $criteria=new CDbCriteria();
        $criteria->with='user';
        $criteria->addCondition('user.status=:userStatus');
        $criteria->params=array(':userStatus'=>'active');
        $newestDevIdRequests=new CActiveDataProvider('UserDevIdRequests', array(
            'criteria'=>$criteria,
        ));

        $criteria=new CDbCriteria();
        $criteria->with='app';
        $criteria->alias='package';
        $criteria->addCondition('package.status=:packageStatus');
        $criteria->addCondition('package.for=:for');
        $criteria->addCondition('app.title!=""');
        $criteria->params=array(
            ':packageStatus'=>'pending',
            ':for'=>'new_app',
        );
        $newestPackages=new CActiveDataProvider('AppPackages', array(
            'criteria'=>$criteria,
        ));

        $criteria=new CDbCriteria();
        $criteria->with='app';
        $criteria->alias='package';
        $criteria->addCondition('package.status=:packageStatus');
        $criteria->addCondition('package.for=:for');
        $criteria->addCondition('app.title!=""');
        $criteria->params=array(
            ':packageStatus'=>'pending',
            ':for'=>'old_app',
        );
        $updatedPackages=new CActiveDataProvider('AppPackages', array(
            'criteria'=>$criteria,
        ));

        Yii::import("tickets.models.*");
        $criteria = new CDbCriteria();
        $criteria->with[]='messages';
        $criteria->compare('messages.visit' ,0);
        $criteria->compare('messages.sender','user');
        $tickets['new'] = Tickets::model()->count($criteria);

        $statistics=array(
            'tickets'=>$tickets['new'],
            'apps'=>Apps::model()->count('title IS NOT NULL'),
            'developers'=>Users::model()->count('role_id = 2'),
            'transactions'=>UserTransactions::model()->count(),
        );

		$this->render('index', array(
            'newestPackages'=>$newestPackages,
            'updatedPackages'=>$updatedPackages,
            'newestPrograms'=>$newestPrograms,
            'devIDRequests'=>$newestDevIdRequests,
            'newestDevelopers'=>$newestDevelopers,
            'tickets'=>$tickets,
            'statistics'=>$statistics,
        ));
	}

}