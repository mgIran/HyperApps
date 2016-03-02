<?php

class PanelController extends Controller
{
	public function actionIndex()
	{
        Yii::app()->theme='market';
        $this->layout = '//layouts/panel';
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
}