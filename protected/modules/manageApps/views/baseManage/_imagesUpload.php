<div class="form-group-lg col-lg-12 col-md-12 col-sm-12 col-xs-12 form-full">
    <?= CHtml::label('تصاویر' ,'uploaderImages' ,array('class' => 'control-label col-lg-2-5 col-md-2-5 col-sm-2 col-xs-12')); ?>
    <div class="col-lg-9-5 col-md-9-5 col-sm-10 col-xs-12">
        <?php
        $images=array();
        $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
            'id' => 'uploaderImages',
            'model' => $model,
            'name' => 'images',
            'maxFiles' => 5,
            'maxFileSize' => 2, //MB
            'url' => $this->createUrl('imagesManage/upload'),
            'deleteUrl' => $this->createUrl('imagesManage/deleteUpload'),
            'acceptedFiles' => 'image/jpeg , image/png',
            'serverFiles' => $images,
            'data' => array('id'=>$model->id),
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
    </div>
</div>