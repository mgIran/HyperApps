<?php

/**
 * This is the model class for table "{{reports}}".
 *
 * The followings are the available columns in table '{{reports}}':
 * @property integer $id
 * @property string $app_id
 * @property string $reason
 * @property string $description
 * 
 * The followings are the available model relations:
 * @property Apps $app
 */
class Reports extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{reports}}';
	}

    public $reasons = [
        'محتوای این نرم افزار نامناسب است.' => 'محتوای این نرم افزار نامناسب است.',
        'نرم افزار در دسته بندی نامناسب قرار گرفته است.' => 'نرم افزار در دسته بندی نامناسب قرار گرفته است.',
        'نرم افزار اسپم و چندین بار ثبت شده است.' => 'نرم افزار اسپم و چندین بار ثبت شده است.',
        'قیمت نرم افزار نامناسب است.' => 'قیمت نرم افزار نامناسب است.',
        'دانلود نرم افزار مشکل دارد.' => 'دانلود نرم افزار مشکل دارد.',
        'نرم افزار ارائه شده مشمول «فهرست مصادیق محتوای مجرمانه» می‌شود.' => 'نرم افزار ارائه شده مشمول «فهرست مصادیق محتوای مجرمانه» می‌شود.',
        'دلیل دیگر ...' => 'دلیل دیگر ...',
    ];
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('app_id, reason', 'required'),
			array('app_id', 'length', 'max'=>10),
			array('reason', 'length', 'max'=>255),
			array('description', 'length', 'max'=>512),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, app_id, reason, description', 'safe', 'on'=>'search'),
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
			'app' => array(self::BELONGS_TO, 'Apps', 'app_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'app_id' => 'App',
			'reason' => 'دلیل‌ گزارش',
			'description' => 'توضیحات شما',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('app_id',$this->app_id,true);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('description',$this->description,true);
		$criteria->order = 'id DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Reports the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
