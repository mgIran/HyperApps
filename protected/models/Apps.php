<?php

/**
 * This is the model class for table "ym_apps".
 *
 * The followings are the available columns in table 'ym_apps':
 * @property string $id
 * @property string $title
 * @property string $developer_id
 * @property string $category_id
 * @property string $status
 * @property double $price
 * @property string $file_name
 * @property string $icon
 * @property string $description
 * @property string $change_log
 * @property string $permissions
 * @property double $size
 * @property string $version
 * @property string $confirm
 * @property string $platform_id
 * @property string $developer_team
 *
 * The followings are the available model relations:
 * @property AppImages[] $images
 * @property AppPlatforms $platform
 * @property Users $developer
 * @property AppCategories $category
 */
class Apps extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ym_apps';
	}

	private $_purifier;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{

		$this->_purifier = new CHtmlPurifier();
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('title, category_id, price, version ,platform_id ,file_name ,icon', 'required'),
            array('price, size, platform_id', 'numerical'),
			array('description, change_log','filter','filter'=>array($this->_purifier,'purify')),
			array('title, icon', 'length', 'max'=>50),
			array('developer_id, category_id, platform_id', 'length', 'max'=>10),
			array('status', 'length', 'max'=>7),
			array('file_name', 'length', 'max'=>100),
			array('version', 'length', 'max'=>20),
			array('confirm', 'length', 'max'=>8),
			array('description, change_log, permissions ,developer_team ,_purifier', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, developer_id, category_id, status, price, file_name, icon, description, change_log, permissions, size, version, confirm, platform_id', 'safe', 'on'=>'search'),
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
			'images' => array(self::HAS_MANY, 'AppImages', 'app_id'),
			'platform' => array(self::BELONGS_TO, 'AppPlatforms', 'platform_id'),
			'developer' => array(self::BELONGS_TO, 'Users', 'developer_id'),
			'category' => array(self::BELONGS_TO, 'AppCategories', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'id' => 'شناسه',
            'title' => 'عنوان',
            'developer_id' => 'توسعه دهنده',
            'category_id' => 'دسته',
            'status' => 'وضعیت',
            'price' => 'قیمت',
            'file_name' => 'فایل',
            'icon' => 'آیکون',
            'description' => 'توضیحات',
            'change_log' => 'لیست تغییرات',
            'permissions' => 'دسترسی ها',
            'size' => 'حجم',
            'version' => 'نسخه',
			'confirm' => 'وضعیت انتشار',
			'platform_id' => 'پلتفرم',
            'developer_team' => 'تیم توسعه دهنده'
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
		$criteria->compare('developer_id',$this->developer_id,true);
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('icon',$this->icon,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('change_log',$this->change_log,true);
		$criteria->compare('permissions',$this->permissions,true);
		$criteria->compare('size',$this->size);
		$criteria->compare('version',$this->version,true);
		$criteria->compare('confirm',$this->confirm,true);
		$criteria->compare('platform_id',$this->platform_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Apps the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
