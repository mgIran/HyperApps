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