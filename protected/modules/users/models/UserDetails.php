<?php

/**
 * This is the model class for table "ym_user_details".
 *
 * The followings are the available columns in table 'ym_user_details':
 * @property string $id
 * @property string $user_id
 * @property string $fa_name
 * @property string $en_name
 * @property string $fa_web_url
 * @property string $en_web_url
 * @property string $national_code
 * @property string $national_card_image
 * @property string $phone
 * @property string $zip_code
 * @property string $address
 * @property double $credit
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class UserDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ym_user_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('credit', 'numerical'),
			array('user_id, national_code, zip_code', 'length', 'max'=>10),
			array('fa_name, en_name, national_card_image', 'length', 'max'=>50),
			array('fa_web_url, en_web_url', 'length', 'max'=>255),
			array('phone', 'length', 'max'=>11),
			array('address', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, fa_name, en_name, fa_web_url, en_web_url, national_code, national_card_image, phone, zip_code, address, credit', 'safe', 'on'=>'search'),
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
			'user' => array(self::HAS_ONE, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'شناسه',
			'user_id' => 'کاربر',
			'fa_name' => 'نام فارسی',
			'en_name' => 'نام انگلیسی',
			'fa_web_url' => 'آدرس سایت فارسی',
			'en_web_url' => 'آدرس سایت انگلیسی',
			'national_code' => 'کد ملی',
			'national_card_image' => 'تصویر کارت ملی',
			'phone' => 'تلفن',
			'zip_code' => 'کد پستی',
			'address' => 'نشانی دقیق پستی',
			'credit' => 'اعتبار',
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('fa_name',$this->fa_name,true);
		$criteria->compare('en_name',$this->en_name,true);
		$criteria->compare('fa_web_url',$this->fa_web_url,true);
		$criteria->compare('en_web_url',$this->en_web_url,true);
		$criteria->compare('national_code',$this->national_code,true);
		$criteria->compare('national_card_image',$this->national_card_image,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('zip_code',$this->zip_code,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('credit',$this->credit);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}