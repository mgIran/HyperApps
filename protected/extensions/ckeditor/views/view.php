<?php
echo CHtml::activeTextArea($model, $attribute, $htmlOptions);
if($config=='default')
{
    Yii::app()->clientScript->registerScript('CKEditor',"
        CKEDITOR.replace( '".get_class($model).'_'.$attribute."', {
            customConfig: 'custom_config.js'
        });
    ");
}
else
{
    Yii::app()->clientScript->registerScript('CKEditor',"
        CKEDITOR.replace( '".get_class($model).'_'.$attribute."', {
            ".$config."
        });
    ");
}