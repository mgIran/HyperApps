<?php
/* @var $this AppsController */
/* @var $model Apps */
/* @var $images Array */
?>
<?php
$this->widget('ext.dropZoneUploader.dropZoneUploader', array(
    'id' => 'uploader',
    'model' => $model,
    'name' => 'image',
    'maxFiles' => 10,
    'maxFileSize' => 0.2, //MB
    'data'=>array('app_id'=>$model->id),
    'url' => $this->createUrl('/developers/apps/uploadImage'),
    'deleteUrl' => $this->createUrl('/developers/apps/deleteImage'),
    'acceptedFiles' => 'image/jpeg , image/png',
    'serverFiles' => $images,
    'onSuccess' => '
                var responseObj = JSON.parse(res);
                if(responseObj.state == "ok")
                {
                    {serverName} = responseObj.fileName;
                }else if(responseObj.state == "error"){
                    console.log(responseObj.msg);
                }
            ',
));
?>