<?php

/**
 * This is the model class for table "ym_users".
 *
 * The followings are the available columns in table 'ym_users':
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $role_id
 * @property string $repeatPassword
 * @property string $oldPassword
 * @property string $newPassword
 *
 * The followings are the available model relations:
 * @property Apps[] $apps
 * @property UserDetails[] $userDetails
 * @property UserRoles $role
 */
class Users extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'ym_users';
    }

    public $repeatPassword;
    public $oldPassword;
    public $newPassword;
    public $roleId;
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email, password', 'required' ,'on' => 'create'),
            array('role_id', 'default' ,'value' => 1,'on' => 'create'),
            array('password, repeatPassword, email', 'required' , 'on' => 'create'),
            array('email' , 'required' ,'on' => 'email'),
            array('email' , 'email'),
            array('oldPassword ,newPassword ,repeatPassword', 'required' , 'on'=>'update'),
            array('email' , 'filter' , 'filter' => 'trim' ,'on' => 'create'),
            array('email' , 'unique' ,'on' => 'create'),
            array('username, password', 'length', 'max'=>100 ,'on' => 'create'),
            array('repeatPassword', 'compare', 'compareAttribute'=>'newPassword' ,'operator'=>'==', 'message' => 'رمز های عبور همخوانی ندارند' , 'on'=>'update'),
            array('repeatPassword', 'compare', 'compareAttribute'=>'password' ,'operator'=>'==', 'message' => 'رمز های عبور همخوانی ندارند' , 'on'=>'create'),
            array('email', 'length', 'max'=>255),
            array('role_id', 'length', 'max'=>10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, username, password, roleId', 'safe', 'on'=>'search'),
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
            'apps' => array(self::HAS_MANY, 'Apps', 'developer_id'),
            'userDetails' => array(self::HAS_ONE, 'UserDetails', 'user_id'),
            'role' => array(self::BELONGS_TO, 'UserRoles', 'role_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'username' => 'نام کاربری',
            'password' => 'کلمه عبور',
            'role_id' => 'نقش',
            'email' => 'پست الکترونیک',
            'repeatPassword' => 'تکرار کلمه عبور',
            'oldPassword' => 'کلمه عبور فعلی',
            'newPassword' => 'کلمه عبور جدید',
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
        $criteria->compare('username',$this->username,true);
        $criteria->compare('password',$this->password,true);
        $criteria->addSearchCondition('role.id' , $this->roleId );
        $criteria->with = array('role');
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Users the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    protected function afterValidate()
    {
        $this->password = $this->encrypt($this->password);
        return parent::afterValidate();
    }

    public function encrypt($value)
    {
        $enc = NEW bCrypt();
        return $enc->hash($value);
    }

    public function beforeSave(){
        if(parent::beforeSave())
        {
            $this->username = $this->email;
            return true;
        }
    }

    /**
     * Check this username is exist in database or not
     */
    public function oldPass($attribute,$params)
    {
        $bCrypt = new bCrypt();
        $record = Users::model()->findByAttributes( array( 'username' => $this->username ) );
        if ( !$bCrypt->verify( $this->$attribute, $record->password ) )
            $this->addError( $attribute, 'رمز عبور فعلی اشتباه است' );
    }
}