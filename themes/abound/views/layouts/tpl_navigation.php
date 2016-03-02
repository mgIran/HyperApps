    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a href="#" class="menu-btn icon-reorder show-in-tablet" data-toggle="collapse" data-target=".nav-collapse">
                </a>

                <!-- Be sure to leave the brand out there if you want it shown -->
                <a class="brand" target="_blank" href="<?= Yii::app()->createAbsoluteUrl('//'); ?>"><?= Yii::app()->name; ?></a>
                <?php
                if(!Yii::app()->user->isGuest) {
                    ?>
                    <div class="nav-collapse">
                        <?php $this->widget( 'zii.widgets.CMenu', array(
                            'htmlOptions' => array( 'class' => 'pull-right nav' ),
                            'submenuHtmlOptions' => array( 'class' => 'dropdown-menu' ),
                            'itemCssClass' => 'item-test',
                            'encodeLabel' => false,
                            'items' => Controller::createAdminMenu()
                        ) ); ?>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <div class="subnav navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <?php
                if(0) {
                ?>
                <div class="style-switcher pull-left">
                    <a href="javascript:chooseStyle('none', 60)" checked="checked"><span class="style"
                                                                                         style="background-color:#0088CC;"></span></a>
                    <a href="javascript:chooseStyle('style2', 60)"><span class="style"
                                                                         style="background-color:#7c5706;"></span></a>
                    <a href="javascript:chooseStyle('style3', 60)"><span class="style"
                                                                         style="background-color:#468847;"></span></a>
                    <a href="javascript:chooseStyle('style4', 60)"><span class="style"
                                                                         style="background-color:#4e4e4e;"></span></a>
                    <a href="javascript:chooseStyle('style5', 60)"><span class="style"
                                                                         style="background-color:#d85515;"></span></a>
                    <a href="javascript:chooseStyle('style6', 60)"><span class="style"
                                                                         style="background-color:#a00a69;"></span></a>
                    <a href="javascript:chooseStyle('style7', 60)"><span class="style"
                                                                         style="background-color:#a30c22;"></span></a>
                </div>
                <?php
                }
                ?>
            </div>
            <!-- container -->
        </div>
        <!-- navbar-inner -->
    </div><!-- subnav -->
