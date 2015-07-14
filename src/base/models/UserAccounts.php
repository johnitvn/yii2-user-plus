<?php
namespace johnitvn\userplus\base\models;

use Yii;
use johnitvn\userplus\base\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * The base User Accounts for all modules in <b>User Plus</b> extension
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 * 
 * @property integer $id
 * @property string $login
 * @property string $username
 * @property string $password_hash
 * @property string $auth_key
 * @property integer $administrator
 * @property integer $creator
 * @property string $creator_ip
 * @property string $confirm_token
 * @property string $recovery_token
 * @property integer $blocked_at
 * @property integer $confirmed_at
 * @property integer $created_at
 * @property integer $updated_at
 */
class UserAccounts extends ActiveRecord implements IdentityInterface {

    /**
     * @var User Accounts Event
     */
    const BEFORE_CREATE = 'beforeCreate';

    /**
     * @var User Accounts Event
     */
    const AFTER_CREATE = 'afterCreate';

    /**
     * @var User Accounts Event
     */
    const BEFORE_CONSOLE_CREATE = 'beforeConsoleCreate';

    /**
     * @var User Accounts Event
     */
    const AFTER_CONSOLE_CREATE = 'afterConsoleCreate';

    /**
     * @var User Accounts Event
     */
    const BEFORE_REGISTER = 'beforeRegister';

    /**
     * @var User Accounts Event
     */
    const AFTER_REGISTER = 'afterRegister';

      /**
     * @var User Accounts Event
     */
    const BEFORE_CHANGE_PASSWORD = 'beforeChangePassword';

    /**
     * @var User Accounts Event
     */
    const AFTER_CHANGE_PASSWORD = 'afterChangePassword';

    /**
     * @var Use for creator field when user created by console application
     */
    const CREATOR_BY_CONSOLE = -2;

    /**
     * @var Use for creator field when user registed by yourself
     */
    const CREATOR_BY_REGISTER = -1;

    /**
     *
     * @var string User's plain password
     */
    public $password;

    /**
     *
     * @var string User comfirm password(Need for creat,register,change password)
     */
    public $confirm_password;
    
    
    /**
     *
     * @var string Old password use for change password
     */
    public $old_password;
    
    /**
     *
     * @var string New password use for change password
     */
    public $new_password;

    /**
     * Returns the validation rules for attributes.
     * @return array validation rules
     * @see http://www.yiiframework.com/doc-2.0/yii-base-model.html#rules()-detail
     */
    public function rules() {
        return [
            // login rules
            'loginRequired' => ['login', 'required', 'on' => ['register', 'create', 'console-create']],
            'loginLength' => ['login', 'string', 'max' => 255],
            'loginUnique' => ['login', 'unique', 'message' => Yii::t('user', 'This account name has already been taken')],
            'loginTrim' => ['login', 'trim'],
            // password rules
            'passwordRequired' => ['password', 'required', 'on' => ['register', 'create', 'console-create']],
            'passwordLength' => ['password', 'string', 'min' => 6],
            //confirm password rules
            'confirmPasswordRequired' => ['password', 'required', 'on' => ['register', 'create']],
            'confirmPasswordLength' => ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t("user", "Comfirm Passwords don't match")],
            'oldPasswordRequired' => ['old_password', 'required', 'on' => ['change_password']],

        ];
    }

    /**
     * Returns a list of scenarios and the corresponding active attributes.  
     * @return array a list of scenarios and the corresponding active attributes.
     * @see http://www.yiiframework.com/doc-2.0/yii-base-model.html#scenarios()-detail
     */
    public function scenarios() {
        return [
            'create' => ['login', 'password', 'confirm_password'],
            'register' => ['login', 'password', 'confirm_password', 'confirm_token'],
            'console-create' => ['login', 'password'],
            'toggle-block' => ['blocked_at'],
            'block' => ['blocked_at'],
            'unblock' => ['blocked_at'],
            'toggle-administrator' => ['administrator'],
            'update'=> ['password', 'confirm_password'],
            'change_password' => ['password', 'confirm_password','new_password','old_password'],
        ];
    }
    
    /**
     * Returns the attribute labels.  
     * @return array Attribute labels (name => label).
     * @see http://www.yiiframework.com/doc-2.0/yii-base-model.html#attributeLabels()-detail
     */
    public function attributeLabels() 
    { 
        return [ 
            'id' => Yii::t('app', 'ID'),
            'login' => Yii::t('app', 'Login'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'administrator' => Yii::t('app', 'Administrator'),
            'creator' => Yii::t('app', 'Creator'),
            'creator_ip' => Yii::t('app', 'Creator Ip'),
            'confirm_token' => Yii::t('app', 'Confirm Token'),
            'recovery_token' => Yii::t('app', 'Recovery Token'),
            'blocked_at' => Yii::t('app', 'Blocked At'),
            'confirmed_at' => Yii::t('app', 'Confirmed At'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ]; 
    } 

    /**
     * This method is called at the beginning of inserting or updating a record.
     * @param boolean $insert whether this method called while inserting a record.
     * If false, it means the method is called while updating a record.
     * @return boolean whether the insertion or updating should continue.
     * If false, the insertion or updating will be cancelled.
     * @see http://www.yiiframework.com/doc-2.0/yii-db-baseactiverecord.html#beforeSave()-detail
     */
    public function beforeSave($insert) {
        if ($insert) {
            $this->blocked_at = null;
            $this->created_at = time();
            $this->updated_at = -1;
        } else {
            $this->updated_at = time();
        }

        if ($this->password !== null) {
            $this->setPassword($this->password);
        }
        return true;
    }
    
    
    public function consoleCreate(){
        $this->trigger(self::BEFORE_CONSOLE_CREATE);  

        $this->administrator = true;
        $this->creator = self::CREATOR_BY_CONSOLE; 
        $this->creator_ip = Yii::t('user','Local');
        $this->confirmed_at = time();    

        if(!$this->save()){
            return false;
        }
        $this->trigger(self::AFTER_CONSOLE_CREATE);   
        return true;
    }
   

    /**
    * Create user
    * @return boolean whether user creat success
    */
    public function create($creatorUserId){ 
        $this->trigger(self::BEFORE_CREATE);
        
        $this->creator = $creatorUserId; 
        $this->administrator = false;      
        $this->confirmed_at = time();  
        $this->prepareCreatorIp();

        if(!$this->save()){
            return false;
        }
        $this->trigger(self::AFTER_CREATE); 
        return true;  
    }

    /**
    * Register user
    * @return boolean whether user register success
    */
    public function register(){     
        $this->trigger(self::BEFORE_REGISTER);  

        $this->administrator = false;
        $this->creator = self::CREATOR_BY_REGISTER; 
        $this->prepareCreatorIp();

        if(!$this->save()){
            return false;
        }

        $this->trigger(self::AFTER_REGISTER);   
        return true;
    }

     /**
    * Register user
    * @return boolean whether user register success
    */
    public function changePassword(){     
        $this->trigger(self::BEFORE_CHANGE_PASSWORD);          
        if($this->validatePassword($this->old_password)){
            $this->password = $this->new_password;
            if(!$this->save()){
                return false;
            }
        }else{
            $this->addError('old_password',Yii::t("user","Your current password is not match"));
            return false;
        }
       
        
        $this->trigger(self::AFTER_CHANGE_PASSWORD);   
        return true;
    }
    
    /**
    * Block user
    * @return boolean whether user block success
    */
    public function block(){
        $this->blocked_at = time();
        return $this->save();
    }

    /**
    * Unblock user
    * @return boolean whether user unblock success
    */
    public function unblock(){
        $this->blocked_at = null;
        return $this->save();
    }
    
    /**
    * Toggle block user
    * @return boolean whether toogle success
    */
    public function toggleBlock(){
        $this->blocked_at = $this->blocked_at==null?time():null;
        return $this->Save();
    }


    /**
    * Toggle administrator perimistion of user
    * @return boolean whether toogle success
    */
    public function toggleAdministrator(){
        $this->administrator = $this->administrator?0:1;
        return $this->Save();
    }

    
    /**
     * Check user is actived status
     *
     * @return boolean whether user is actived
     */
    public function isBlocked(){
        return $this->blocked_at !== null ;
    }

    /**
     * Check administrator permistion of user
     *
     * @return boolean whether user is super user
     */
    public function isAdministrator(){
        return $this->administrator == true;
    }
    
    /**
    * Validates password
    *
    * @param string $password password to validate
    * @return boolean if password provided is valid for current user
    */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
    * Generates password hash from password and sets it to the model
    *
    * @param string $password
    */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    
    /**
     * Find user by login field
     *
     * @param string $email email to find
     * @return boolean|UserAccounts 
     */
    public static function findIdentityByLogin($login){
        $model = static::findOne(['login'=>$login]);
        return $model;
    }

    /**
     * Finds an identity by the given ID.
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id) {
        return static::findOne($id);
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|integer an ID that uniquely identifies a user identity.
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }
    
    public static function tableName() {
        return 'user_accounts';
    }
    
    /**
    * Setup creator's ip is current client ip
    * @return void 
    */
    protected function prepareCreatorIp(){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $this->creator_ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $this->creator_ip = $_SERVER['HTTP_X_FORWARDED_FOR']; 
        } else {
            $this->creator_ip = $_SERVER['REMOTE_ADDR'];
        } 
    }

    

}
