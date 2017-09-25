<?php
class ApiController extends ApiBaseController
{
    protected $request = null;

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'RestAccessControl + search, find, list, page, comment',
            'RestAuthControl + testAuth',
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
            $limit = 10;
            if (isset($this->request['limit']))
                $limit = $this->request['limit'];

            Yii::import('users.models.*');

            $criteria = new CDbCriteria();

            $criteria->with = ['publisher', 'publisher.userDetails', 'persons', 'category'];

            $criteria->addCondition('t.status=:status AND t.confirm=:confirm AND t.deleted=:deleted AND (SELECT COUNT(book_packages.id) FROM ym_book_packages book_packages WHERE book_packages.book_id=t.id) != 0');
            $criteria->params[':status'] = 'enable';
            $criteria->params[':confirm'] = 'accepted';
            $criteria->params[':deleted'] = 0;
            $criteria->order = 't.confirm_date DESC';

            $terms = explode(' ', $term);
            $condition = '
                ((t.title regexp :term) OR
                (userDetails.fa_name regexp :term OR userDetails.nickname regexp :term) OR
                (persons.name_family regexp :term) OR
                (category.title regexp :term))';
            $criteria->params[":term"] = $term;

            foreach ($terms as $key => $term)
                if ($term) {
                    if ($condition)
                        $condition .= " OR (";
                    $condition .= "
                        (t.title regexp :term$key) OR
                        (userDetails.fa_name regexp :term$key OR userDetails.nickname regexp :term$key) OR
                        (persons.name_family regexp :term$key) OR
                        (category.title regexp :term$key))";
                    $criteria->params[":term$key"] = $term;
                }
            $criteria->together = true;

            $criteria->addCondition($condition);
            $criteria->limit = $limit;

            /* @var Apps[] $apps */
            $apps = Apps::model()->findAll($criteria);

            $result = [];
            foreach ($apps as $app)
                $result[] = [
                    'id' => intval($app->id),
                    'title' => $app->title,
                    'icon' => Yii::app()->createAbsoluteUrl('/uploads/apps/icons') . '/' . $app->icon,
                    'developer_name' => $app->getDeveloperName(),
                    'rate' => floatval($app->rate),
                    'price' => doubleval($app->price),
                    'hasDiscount' => $app->hasDiscount(),
                    'offPrice' => $app->hasDiscount() ? doubleval($app->offPrice) : 0,
                ];

            if ($result)
                $this->_sendResponse(200, CJSON::encode(['status' => true, 'result' => $result]), 'application/json');
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

                    // Get similar books
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
                            'icon' => Yii::app()->createAbsoluteUrl('/uploads/apps/icons') . '/' . $app->icon,
                            'developer_name' => $app->getDeveloperName(),
                            'rate' => floatval($app->rate),
                            'price' => doubleval($app->price),
                            'hasDiscount' => $app->hasDiscount(),
                            'offPrice' => $app->hasDiscount() ? doubleval($app->offPrice) : 0,
                        ];

                    $app = [
                        'id' => intval($record->id),
                        'title' => $record->title,
                        'icon' => Yii::app()->createAbsoluteUrl('/uploads/apps/icons') . '/' . $record->icon,
                        'developer_name' => $record->getDeveloperName(),
                        'rate' => floatval($record->rate),
                        'price' => doubleval($record->price),
                        'hasDiscount' => $record->hasDiscount(),
                        'offPrice' => $record->hasDiscount() ? doubleval($record->offPrice) : 0,
                        'category_id' => intval($record->category_id),
                        'description' => strip_tags(str_replace('<br/>', '\n', str_replace('<br>', '\n', $record->description))),
                        'seen' => intval($record->seen),
                        'comments' => $comments,
                        'similar' => $similar,
                    ];

                    break;
                default:
                    $app = null;
                    break;
            }

            if ($app)
                $this->_sendResponse(200, CJSON::encode(['status' => true, 'book' => $app]), 'application/json');
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
                    foreach ($apps as $app)
                        $list[] = [
                            'id' => intval($app->id),
                            'title' => $app->title,
                            'icon' => Yii::app()->getBaseUrl(true).'/uploads/apps/icons/' . $app->icon,
                            'developer' => $app->getDeveloperName(),
                            'rate' => $app->getRate(),
                            'price' => (double)$app->price,
                            'hasDiscount' => $app->hasDiscount(),
                            'offPrice' => $app->hasDiscount()?(double)$app->getOffPrice():null,
                        ];
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
                    $rateModel = AppRatings::model()->findAllByAttributes(array('user_id' => $comment->creator_id, 'book_id' => $comment->owner_id));
                    if ($rateModel)
                        AppRatings::model()->deleteAllByAttributes(array('user_id' => $comment->creator_id, 'book_id' => $comment->owner_id));
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

    /** ------------------------------------------------- Authorized Api ------------------------------------------------ **/
    public function actionTestAuth(){
        $this->_sendResponse(200, CJSON::encode(['status' => true, 'message' => 'Access Token works properly.']), 'application/json');  
    }
}