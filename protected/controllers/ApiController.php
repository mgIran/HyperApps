<?php
class ApiController extends ApiBaseController
{
    protected $request = null;
    public $active_gateway;

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'RestAccessControl + search, find, list, page, comment, creditPrices',
            'RestAuthControl + profile, editProfile, credit',
        );
    }

    public function beforeAction($action)
    {
        $this->request = $this->getRequest();
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public function actionSearch()
    {
        if (isset($this->request['query']) and !empty($term = trim($this->request['query']))) {
            $limit = 20;
            $offset = 0;
            if (isset($this->request['limit']) && !empty($this->request['limit'])) {
                $limit = (int)$this->request['limit'];
                if (isset($this->request['offset']) && !empty($this->request['offset']))
                    $offset = (int)$this->request['offset'];
            }

            Yii::import('users.models.*');

            $criteria = new CDbCriteria();

            if (isset($this->request['platform_id'])) {
                $criteria->addCondition('platform_id=:platform_id');
                $criteria->params[':platform_id'] = $this->request['platform_id'];
            }

            $criteria->addCondition('status=:status AND confirm=:confirm AND deleted=:deleted AND (SELECT COUNT(app_images.id) FROM ym_app_images app_images WHERE app_images.app_id=t.id) != 0');
            $criteria->params[':status'] = 'enable';
            $criteria->params[':confirm'] = 'accepted';
            $criteria->params[':deleted'] = 0;

            $criteria->order = 't.id DESC';

            $terms = explode(' ', urldecode($term));
            $sql = null;
            foreach ($terms as $key => $term)
                if ($term) {
                    if (!$sql)
                        $sql = "(";
                    else
                        $sql .= " OR (";
                    $sql .= "t.title regexp :term$key OR t.description regexp :term$key OR category.title regexp :term$key)";
                    $criteria->params[":term$key"] = $term;
                }
            $criteria->with[] = 'category';
            $criteria->addCondition($sql);

            $criteria->together = true;
            $criteria->limit = $limit;
            $criteria->offset = $offset;

            /* @var Apps[] $apps */
            $apps = Apps::model()->findAll($criteria);
            $listCount = Apps::model()->count($criteria);

            $result = [];
            foreach ($apps as $app){
                $images = [];
                $imagePath = Yii::getPathOfAlias("webroot") . "/uploads/apps/images/";
                $imageUrl = Yii::app()->getBaseUrl(true) . "/uploads/apps/images/";
                foreach($app->images as $image)
                    if(file_exists($imagePath . $image->image))
                        $images[] = $imageUrl . $image->image;
                $result[] = [
                    'id' => intval($app->id),
                    'title' => $app->title,
                    'icon' => Yii::app()->getBaseUrl(true) . '/uploads/apps/icons/' . $app->icon,
                    'developer' => $app->getDeveloperName(),
                    'rate' => $app->getRate(),
                    'price' => (double)$app->price,
                    'hasDiscount' => $app->hasDiscount(),
                    'offPrice' => $app->hasDiscount()?(double)$app->getOffPrice():null,
                    'images' => $images
                ];
            }

            if ($result)
                $this->_sendResponse(200, CJSON::encode(['status' => true, 'totalRecords' => $listCount, 'result' => $result]), 'application/json');
            else
                $this->_sendResponse(200, CJSON::encode(['status' => false, 'message' => 'نتیجه ای یافت نشد.']), 'application/json');
        } else
            $this->_sendResponse(200, CJSON::encode(['status' => false, 'message' => 'Query variable is required.']), 'application/json');
    }
    /**
     * Get a specific model
     */
    public function actionFind()
    {
        if (isset($this->request['entity']) and isset($this->request['id'])) {
            $entity = $this->request['entity'];
            $criteria = new CDbCriteria();

            switch (trim(ucfirst(strtolower($entity)))) {
                case 'App':
                    $criteria->addCondition('id = :id');
                    $criteria->params[':id'] = $this->request['id'];
                    $criteria->together = true;
                    /* @var Apps $record */
                    $record = Apps::model()->find($criteria);

                    if (!$record)
                        $this->_sendResponse(200, CJSON::encode(['status' => false, 'message' => 'نتیجه ای یافت نشد.']), 'application/json');
                    $record->seen++;
                    $record->save(false);

                    $imagePath = Yii::getPathOfAlias("webroot") . "/uploads/apps/images/";
                    $imageUrl = Yii::app()->getBaseUrl(true) . "/uploads/apps/images/";
                    $images =[];
                    foreach($record->images as $image)
                        if(file_exists($imagePath.$image->image))
                            $images[] = $imageUrl.$image->image;

                    Yii::import('users.models.*');
                    Yii::import('comments.models.*');

                    // Get comments
                    $criteria = new CDbCriteria;
                    $criteria->compare('owner_name', 'Apps');
                    $criteria->compare('owner_id', $record->id);
                    $criteria->compare('t.status', Comment::STATUS_APPROWED);
                    $criteria->order = 'parent_comment_id, create_time ';
                    $criteria->order .= 'DESC';
                    $criteria->with = 'user';
                    /* @var Comment[] $commentsList */
                    $commentsList = Comment::model()->findAll($criteria);

                    $comments = [];
                    foreach ($commentsList as $comment)
                        $comments[] = [
                            'id' => intval($comment->comment_id),
                            'text' => $comment->comment_text,
                            'username' => $comment->userName,
                            'rate' => $comment->userRate ? floatval($comment->userRate) : false,
                            'createTime' => doubleval($comment->create_time),
                        ];

                    // Get similar apps
                    $criteria = Apps::model()->getValidApps(array($record->category_id));
                    $criteria->addCondition('id!=:id');
                    $criteria->params[':id'] = $record->id;
                    $criteria->limit = 10;
                    /* @var Apps[] $similarBooks */
                    $similarBooks = Apps::model()->findAll($criteria);

                    $similar = [];
                    foreach ($similarBooks as $app)
                        $similar[] = [
                            'id' => intval($app->id),
                            'title' => $app->title,
                            'icon' => Yii::app()->getBaseUrl(true).'/uploads/apps/icons/' . $app->icon,
                            'developer' => $app->getDeveloperName(),
                            'rate' => $app->getRate(),
                            'price' => (double)$app->price,
                            'hasDiscount' => $app->hasDiscount(),
                            'offPrice' => $app->hasDiscount()?(double)$app->getOffPrice():null,
                        ];
                    $filePath = Yii::getPathOfAlias("webroot") . "/uploads/apps/files/";
                    if($record->platform) {
                        $platform = $record->platform;
                        $filesFolder = $platform->name;
                        $filePath = Yii::getPathOfAlias("webroot") . "/uploads/apps/files/{$filesFolder}/";
                    }
                    $app = [
                        'id' => intval($record->id),
                        'title' => $record->title,
                        'icon' => Yii::app()->createAbsoluteUrl('/uploads/apps/icons') . '/' . $record->icon,
                        'developer' => $record->getDeveloperName(),
                        'rate' => floatval($record->rate),
                        'price' => doubleval($record->price),
                        'hasDiscount' => $record->hasDiscount(),
                        'offPrice' => $record->hasDiscount() ? doubleval($record->offPrice) : 0,
                        'category_id' => intval($record->category_id),
                        'description' => strip_tags(str_replace('<br/>', '\n', str_replace('<br>', '\n', $record->description))),
                        'seen' => intval($record->seen),
                        'install' => intval($record->install),
                        'package_name' => $record->lastPackage->package_name,
                        'version_name' => $record->lastPackage->version,
                        'version_code' => $record->lastPackage->version_code,
                        'app_size' => Controller::fileSize($filePath.$record->lastPackage->file_name),
                        'images' => $images,
                        'comments' => $comments,
                        'similar' => $similar,
                    ];
                    break;
                default:
                    $app = null;
                    break;
            }

            if ($app)
                $this->_sendResponse(200, CJSON::encode(['status' => true, 'app' => $app]), 'application/json');
            else
                $this->_sendResponse(200, CJSON::encode(['status' => false, 'message' => 'نتیجه ای یافت نشد.']), 'application/json');
        } else
            $this->_sendResponse(200, CJSON::encode(['status' => false, 'message' => 'Entity and ID variables is required.']), 'application/json');
    }
    /**
     * Get list of models
     */
    public function actionList()
    {
        if (isset($this->request['entity']) && $entity = $this->request['entity']) {
            $criteria = new CDbCriteria();
            $criteria->limit = 20;
            $criteria->offset = 0;

            // set LIMIT and OFFSET in Query
            if (isset($this->request['limit']) && !empty($this->request['limit']) && $limit = (int)$this->request['limit']) {
                $criteria->limit = $limit;
                if (isset($this->request['offset']) && !empty($this->request['offset']) && $offset = (int)$this->request['offset'])
                    $criteria->offset = $offset;
            }

            // Execute query on model
            $listCount = 0;
            $list = [];
            switch (trim(ucfirst($entity))) {
                case 'Category':
                    /* @var AppCategories[] $categories */
                    $criteria->limit = 500;
                    if (isset($this->request['parent_id']))
                    {
                        if($this->request['parent_id'] != 0)
                            $criteria->compare('category_id', $this->request['parent_id']);
                        else
                            $criteria->addCondition('parent_id IS NULL');
                    }
                    $categories = AppCategories::model()->findAll($criteria);
                    $listCount = AppCategories::model()->count($criteria);
                    foreach ($categories as $category)
                        $list[] = [
                            'id' => intval($category->id),
                            'title' => $category->title,
                            'parent_id' => intval($category->parent_id),
                            'path' => $category->path
                        ];
                    break;
                case 'App':
                    $criteria->with[] = 'images';
                    $order = 'id DESC';
                    if(isset($this->request['row']))
                    {
                        switch($this->request['row']){
                            case'newest_programs':
                                $this->request['category_id'] = 1;
                                $order = 'id DESC';
                                break;
                            case'newest_games':
                                $this->request['category_id'] = 2;
                                $order = 'id DESC';
                                break;
                            case'newest_edu':
                                $this->request['category_id'] = 3;
                                $order = 'id DESC';
                                break;
                            case'popular_programs':
                                $this->request['category_id'] = 1;
                                $criteria->select = 't.*, AVG(ratings.rate) as avgRate';
                                $criteria->with[] = 'ratings';
                                $criteria->group = 't.id';
                                $criteria->together = true;
                                $criteria->addCondition('ratings.rate IS NOT NULL');
                                $order = 'avgRate DESC, t.id DESC';
                                break;
                            case'popular_games':
                                $this->request['category_id'] = 2;
                                $criteria->select = 't.*, AVG(ratings.rate) as avgRate';
                                $criteria->with[] = 'ratings';
                                $criteria->group = 't.id';
                                $criteria->together = true;
                                $criteria->addCondition('ratings.rate IS NOT NULL');
                                $order = 'avgRate DESC, t.id DESC';
                                break;
                            case'popular_edu':
                                $this->request['category_id'] = 3;
                                $criteria->select = 't.*, AVG(ratings.rate) as avgRate';
                                $criteria->with[] = 'ratings';
                                $criteria->group = 't.id';
                                $criteria->together = true;
                                $criteria->addCondition('ratings.rate IS NOT NULL');
                                $order = 'avgRate DESC, t.id DESC';
                                break;
                            case'best_sellers_programs':
                                $this->request['category_id'] = 1;
                                $criteria->group = 'appBuys.app_id';
                                $order = 'COUNT(appBuys.id) DESC';
                                $criteria->with['appBuys'] = array('joinType' => 'RIGHT OUTER JOIN');
                                $criteria->together = true;
                                break;
                            case'best_sellers_games':
                                $this->request['category_id'] = 1;
                                $criteria->group = 'appBuys.app_id';
                                $order = 'COUNT(appBuys.id) DESC';
                                $criteria->with['appBuys'] = array('joinType' => 'RIGHT OUTER JOIN');
                                $criteria->together = true;
                                break;
                            case'best_sellers_edu':
                                $this->request['category_id'] = 1;
                                $criteria->group = 'appBuys.app_id';
                                $order = 'COUNT(appBuys.id) DESC';
                                $criteria->with['appBuys'] = array('joinType' => 'RIGHT OUTER JOIN');
                                $criteria->together = true;
                                break;
                            default:
                                $this->_sendResponse(200, CJSON::encode(['status' => false, 'message' => "'{$this->request['row']}' is invalid row."]), 'application/json');
                                break;
                        }
                    }
                    else if(isset($this->request['order']))
                        $order = $this->request['order'];

                    if (isset($this->request['category_id'])) {
                        $catIds = AppCategories::model()->getCategoryChilds($this->request['category_id']);
                        $criteria->addInCondition('category_id', $catIds);
                    }

                    if (isset($this->request['platform_id'])) {
                        $criteria->addCondition('platform_id=:platform_id');
                        $criteria->params[':platform_id'] = $this->request['platform_id'];
                    }

                    $criteria->addCondition('status=:status');
                    $criteria->addCondition('confirm=:confirm');
                    $criteria->addCondition('deleted=:deleted');
                    $criteria->addCondition('(SELECT COUNT(app_images.id) FROM ym_app_images app_images WHERE app_images.app_id=t.id) != 0');
                    $criteria->addCondition('(SELECT COUNT(app_packages.id) FROM ym_app_packages app_packages WHERE app_packages.app_id=t.id) != 0');
                    $criteria->params[':status'] = 'enable';
                    $criteria->params[':confirm'] = 'accepted';
                    $criteria->params[':deleted'] = 0;
                    $criteria->order = $order;
                    /* @var Apps[] $apps */
                    $apps = Apps::model()->findAll($criteria);
                    $listCount = Apps::model()->count($criteria);
                    foreach ($apps as $app){
                        $images = [];
                        if($app->images && isset($this->request['row'])){
                            $imagePath = Yii::getPathOfAlias("webroot") . "/uploads/apps/images/";
                            $imageUrl = Yii::app()->getBaseUrl(true) . "/uploads/apps/images/";
                            foreach($app->images as $image)
                                if(file_exists($imagePath . $image->image))
                                    $images[] = $imageUrl . $image->image;
                        }
                        $list[] = [
                            'id' => intval($app->id),
                            'title' => $app->title,
                            'icon' => Yii::app()->getBaseUrl(true) . '/uploads/apps/icons/' . $app->icon,
                            'developer' => $app->getDeveloperName(),
                            'rate' => $app->getRate(),
                            'price' => (double)$app->price,
                            'hasDiscount' => $app->hasDiscount(),
                            'offPrice' => $app->hasDiscount()?(double)$app->getOffPrice():null,
                            'images' => $images,
                        ];
                    }
                    break;
            }

            if ($list)
                $this->_sendResponse(200, CJSON::encode(['status' => true, 'totalRecords' => $listCount,'list' => $list]), 'application/json');
            else
                $this->_sendResponse(200, CJSON::encode(['status' => false, 'message' => 'نتیجه ای یافت نشد.']), 'application/json');
        } else
            $this->_sendResponse(200, CJSON::encode(['status' => false, 'message' => 'Entity variable is required.']), 'application/json');
    }

    public function actionPage()
    {
        if (isset($this->request['name'])) {
            $text = null;
            Yii::import('pages.models.*');
            switch ($this->request['name']) {
                case "about":
                    $text = Pages::model()->findByPk(10)->summary;
                    break;

                case "help":
                    $text = Pages::model()->findByPk(11)->summary;
                    break;

                case "contact":
                    $text = Pages::model()->findByPk(12)->summary;
                    break;
            }

            if ($text)
                $this->_sendResponse(200, CJSON::encode(['status' => true, 'text' => $text]), 'application/json');
            else
                $this->_sendResponse(200, CJSON::encode(['status' => false, 'message' => 'نتیجه ای یافت نشد.']), 'application/json');
        } else
            $this->_sendResponse(200, CJSON::encode(['status' => false, 'message' => 'Name variable is required.']), 'application/json');
    }

    public function actionComment()
    {
        if (isset($this->request['comment'])) {
            $comment = new Comment();
            $comment->attributes = $this->request['comment'];
            $comment->owner_name = "Books";
            $criteria = new CDbCriteria;
            $criteria->compare('owner_name', $comment->owner_name, true);
            $criteria->compare('owner_id', $comment->owner_id);
            $criteria->compare('parent_comment_id', $comment->parent_comment_id);
            $criteria->compare('creator_id', $comment->creator_id);
            $criteria->compare('user_name', $comment->user_name, false);
            $criteria->compare('user_email', $comment->user_email, false);
            $criteria->compare('comment_text', $comment->comment_text, false);
            $criteria->addCondition('create_time>:time');
            $criteria->params[':time'] = time() - 30;
            $model = Comment::model()->find($criteria);
            if ($model)
                $this->_sendResponse(200, CJSON::encode(['status' => false, 'message' => 'تا 30 ثانیه دیگر امکان ثبت نظر وجود ندارد.']), 'application/json');

            if ($comment->save()) {
                if (isset($this->request['comment']['rate'])) {
                    $rateModel = AppRatings::model()->findAllByAttributes(array('user_id' => $comment->creator_id, 'app_id' => $comment->owner_id));
                    if ($rateModel)
                        AppRatings::model()->deleteAllByAttributes(array('user_id' => $comment->creator_id, 'app_id' => $comment->owner_id));
                    $rateModel = new AppRatings();
                    $rateModel->app_id = $comment->owner_id;
                    $rateModel->user_id = $comment->creator_id;
                    $rateModel->rate = $this->request['comment']['rate'];
                    @$rateModel->save();
                }

                $this->_sendResponse(200, CJSON::encode(['status' => true, 'message' => 'نظر شما با موفقیت ثبت شد.']), 'application/json');
            } else
                $this->_sendResponse(200, CJSON::encode(['status' => false, 'message' => 'در عملیات ثبت خطایی رخ داده است! لطفا مجددا تلاش کنید.']), 'application/json');
        } else
            $this->_sendResponse(200, CJSON::encode(['status' => false, 'message' => 'Comment variable is required.']), 'application/json');
    }

    public function actionCreditPrices()
    {
        Yii::app()->getModule('setting');
        $prices = SiteSetting::model()->find('name = :name', [':name' => 'buy_credit_options']);
        $prices = array_map(function ($item) {
            return doubleval($item);
        }, json_decode($prices->value));
        if ($prices)
            $this->_sendResponse(200, CJSON::encode(['status' => true, 'prices' => $prices]), 'application/json');
        else
            $this->_sendResponse(404, CJSON::encode(['status' => false, 'message' => 'نتیجه ای یافت نشد.']), 'application/json');
    }

    /** ------------------------------------------------- Authorized Api ------------------------------------------------ **/
    public function actionProfile()
    {
//        $avatar = ($this->user->userDetails->avatar == '') ? Yii::app()->createAbsoluteUrl('/themes/frontend/images/default-user.png') : Yii::app()->createAbsoluteUrl('/uploads/users/avatar') . '/' . $this->user->userDetails->avatar;
        $this->_sendResponse(200, CJSON::encode(['status' => true, 'user' => [
            'email' => $this->user->email,
            'name' => $this->user->userDetails->fa_name,
            'role' => $this->user->userDetails->roleLabels[$this->user->role->role],
//            'avatar' => $avatar,
            'credit' => doubleval($this->user->userDetails->credit),
            'nationalCode' => $this->user->userDetails->national_code,
            'phone' => $this->user->userDetails->phone,
            'zipCode' => $this->user->userDetails->zip_code,
            'address' => $this->user->userDetails->address,
        ]]), 'application/json');
    }

    public function actionEditProfile()
    {
        if (isset($this->request['profile'])) {
            $profile = $this->request['profile'];
            $profileFields = [
                'name',
                'national_code',
                'phone',
                'zip_code',
                'address',
            ];

            foreach($profile as $key => $field)
                if(!in_array($key, $profileFields))
                    unset($profile[$key]);

            /* @var $detailsModel UserDetails */
            $detailsModel = UserDetails::model()->findByAttributes(array('user_id' => $this->user->id));
            $detailsModel->scenario = 'update_profile';
            $detailsModel->attributes = $profile;
            $detailsModel->fa_name = isset($profile['name'])?$profile['name']:$detailsModel->fa_name;
            if ($detailsModel->save())
                $this->_sendResponse(200, CJSON::encode(['status' => true, 'message' => 'اطلاعات با موفقیت ثبت شد.']), 'application/json');
            else
                $this->_sendResponse(200, CJSON::encode(['status' => false, 'message' => 'در ثبت اطلاعات خطایی رخ داده است. لطفا مجددا تلاش کنید.']), 'application/json');
        } else
            $this->_sendResponse(200, CJSON::encode(['status' => false, 'message' => 'Profile variable is required.']), 'application/json');
    }

    public function actionCredit()
    {
        if (isset($this->request['amount'])) {
            $this->active_gateway = strtolower(SiteSetting::getOption('gateway_active'));
            if($this->active_gateway != 'zarinpal' && $this->active_gateway != 'mellat')
                die('Gateway invalid!! Valid gateways is "zarinpal" or "mellat". Please change gateway in main.php file.');

            $model = UserTransactions::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'status' => 'unpaid'));
            if(!$model)
                $model = new UserTransactions();
            $model->user_id = Yii::app()->user->getId();
            $model->amount = $this->request['amount'];
            $model->date = time();
            if($model->save()){
                $Amount = doubleval($model->amount);
                $CallbackURL = Yii::app()->getBaseUrl(true) . '/users/credit/apiVerify?platform=mobile';
                if($this->active_gateway == 'mellat'){
                    $result = Yii::app()->mellat->PayRequest($Amount * 10, $model->id, $CallbackURL);
                    if(!$result['error']){
                        $ref_id = $result['responseCode'];
                        $model->authority = $ref_id;
                        $model->save(false);
                        $this->_sendResponse(200, CJSON::encode(['status' => true, 'url' => Yii::app()->mellat->getRedirectUrl()]), 'application/json');
                    }else
                        $this->_sendResponse(200, CJSON::encode(['status' => false, 'message' => 'خطای بانکی: ' . Yii::app()->mellat->getResponseText($result['responseCode'])]), 'application/json');
                }else if($this->active_gateway == 'zarinpal'){
                    $siteName = Yii::app()->name;
                    $description = "خرید اعتبار در وبسایت {$siteName}";
                    $result = Yii::app()->zarinpal->PayRequest($Amount, $description, $CallbackURL);
                    $model->authority = Yii::app()->zarinpal->getAuthority();
                    $model->save(false);
                    if($result->getStatus() == 100)
                        $this->_sendResponse(200, CJSON::encode(['status' => true, 'url' => Yii::app()->zarinpal->getRedirectUrl()]), 'application/json');
                    else
                        $this->_sendResponse(200, CJSON::encode(['status' => false, 'message' => 'خطای بانکی: ' . Yii::app()->zarinpal->getError()]), 'application/json');
                }
            }else
                $this->_sendResponse(200, CJSON::encode(['status' => false, 'message' => 'در ثبت اطلاعات خطایی رخ داده است. لطفا مجددا تلاش کنید.']), 'application/json');
        } else
            $this->_sendResponse(200, CJSON::encode(['status' => false, 'message' => 'Amount variable is required.']), 'application/json');
    }
}