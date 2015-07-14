<?php
namespace johnitvn\userplus\basic;


/**
 *
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
interface UserRecoveryableInterface extends EmailableInterface{

    public function recovery();
    
    public function resetPassword();
    
    public function generateRecoveryToken();
    
    public static function findIdentityByRecoveryToken($token);
    
}
