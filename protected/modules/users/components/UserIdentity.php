<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     *
     * @var $_id
     */
    private $_id;

    /**
     * @var string email
     */
    public $email;

    /**
     * Constructor.
     * @param string $email email
     * @param string $password password
     */
    public function __construct($email,$password)
    {
        $this->email=$email;
        $this->password=$password;
    }

    public function authenticate()
    {
        $bCrypt = new bCrypt;
        $record = Users::model()->findByAttributes(array('email'=>$this->email));
        if($record===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else if(!$bCrypt->verify($this->password , $record->password))
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->_id=$record->id;
            $this->setState('roles',$record->role->role);
            $this->setState('type','user');
            $this->setState('email',$record->email);
            $this->setState('username',$record->username);
            $this->errorCode=self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }
}