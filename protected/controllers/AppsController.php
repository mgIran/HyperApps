<?php

class AppsController extends Controller
{
    public $layout = '//layouts/inner';

	public function actionCategoryIndex()
	{
		$this->render('categoryIndex');
	}

	public function actionView($id)
    {
        Yii::import('users.models.*');
        Yii::app()->theme = "market";
        $model = $this->loadModel($id);
		$this->render('view',array(
            'model' => $model
        ));
	}

    /**
     * Show programs list
     */
    public function actionPrograms($id=null, $title=null)
    {
        if(is_null($id))
            $id=1;
        $this->showCategory($id, $title, 'برنامه ها');
    }

    /**
     * Show games list
     */
    public function actionGames($id=null, $title=null)
    {
        if(is_null($id))
            $id=2;
        $this->showCategory($id, $title, 'بازی ها');
    }

    /**
     * Show educations list
     */
    public function actionEducations($id=null, $title=null)
    {
        if(is_null($id))
            $id=3;
        $this->showCategory($id, $title, 'آموزش ها');
    }

    /**
     * Show apps list of category
     */
    public function showCategory($id, $title, $pageTitle)
    {
        Yii::app()->theme='market';
        $this->layout='public';
        $criteria=new CDbCriteria();
        $criteria->addCondition('confirm=:confirm');
        $criteria->addCondition('deleted=:deleted');
        $criteria->addCondition('status=:status');
        $criteria->addCondition('platform_id=:platform');

        $criteria->params=array(
            ':confirm'=>'accepted',
            ':deleted'=>0,
            ':status'=>'enable',
            ':platform'=>$this->platform,
        );

        $categories=AppCategories::model()->getCategoryChilds($id);
        $criteria->addInCondition('category_id', $categories);

        $dataProvider=new CActiveDataProvider('Apps', array(
            'criteria'=>$criteria,
        ));

        $this->render('apps_list', array(
            'dataProvider'=>$dataProvider,
            'title'=>(!is_null($title))?$title:null,
            'pageTitle'=>$pageTitle
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
}