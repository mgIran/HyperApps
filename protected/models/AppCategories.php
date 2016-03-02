<?php

/**
 * This is the model class for table "ym_app_categories".
 *
 * The followings are the available columns in table 'ym_app_categories':
 * @property string $id
 * @property string $title
 * @property string $parent_id
 * @property string $path
 *
 *
 * The followings are the available model relations:
 * @property AppCategories $parent
 * @property AppCategories[] $appCategories
 * @property Apps[] $apps
 */
class AppCategories extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ym_app_categories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'length', 'max'=>50),
			array('parent_id', 'length', 'max'=>10),
            array('path', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, parent_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'parent' => array(self::BELONGS_TO, 'AppCategories', 'parent_id'),
			'appCategories' => array(self::HAS_MANY, 'AppCategories', 'parent_id'),
			'apps' => array(self::HAS_MANY, 'Apps', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'عنوان',
			'parent_id' => 'والد',
            'path' => 'مسیر'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('parent_id',$this->parent_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AppCategories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    public function sortList()
    {
        $parents = $this->findAll( 'parent_id IS NULL order by name' );
        $list = array();
        foreach ( $parents as $parent ) {
            array_push( $list, $parent );
            $childes = $this->getChildesArray($parent->id);
            foreach ( $childes as $child ) {
                array_push( $list, $child );
            }
        }
        return CHtml::listData( $list, 'id', 'fullName' );
    }

    public function adminSortList()
    {
        $parents = $this->findAll( 'parent_id IS NULL order by name' );
        $list = array();
        foreach ( $parents as $parent ) {
            array_push( $list, $parent );
            $childes = $this->getChildesArray($parent->id);
            foreach ( $childes as $childe ) {
                array_push( $list, $childe );
            }
        }
        return CMap::mergeArray( array( '' => '-' ), CHtml::listData( $list, 'id', 'fullName' ) );
    }

    public function getParents( $id = NULL )
    {
        if ( $id )
            $parents = $this->findAll( 'parent_id = :id order by name', array( ':id' => $id ) );
        else
            $parents = $this->findAll( 'parent_id IS NULL order by name' );
        $list = array();
        foreach ( $parents as $parent ) {
            array_push( $list, $parent );
        }
        return CHtml::listData( $list, 'id', 'fullName' );
    }

    public function getFullName()
    {
        $fullName = $this->title;
        $model = $this;
        while ( $model->parent ) {
            $model = $model->parent;
            $fullName = $model->title . '/' . $fullName;
        }
        return $fullName;
    }

    public function getChildesArray( $id )
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition("t.path LIKE :id");
        $criteria->params =array(':id' => "$id%" );
        return $this->findAll($criteria);
    }
}
