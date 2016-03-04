<div class="form">
    <div class="row">
        <?= CHtml::label('تصاویر' ,'uploaderImages' ,array('class' => 'control-label')); ?>
        <?php
        $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
            'id' => 'uploaderImages',
            'name' => 'image',
            'maxFiles' => 15,
            'maxFileSize' => 2, //MB
            'url' => $this->createUrl('/manageApps/imagesManage/upload'),
            'deleteUrl' => $this->createUrl('/manageApps/imagesManage/deleteUploaded'),
            'acceptedFiles' => 'image/jpeg , image/png',
            'serverFiles' => $images,
            'data' => array('app_id'=>$model->id),
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
    <p>
        تصاویر آپلود شده ی فوق به طور خودکار در سیستم ثبت میگردند و نیازی به تایید ندارند .
    </p>
</div>