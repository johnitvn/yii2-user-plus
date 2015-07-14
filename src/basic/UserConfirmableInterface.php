<?php
namespace johnitvn\userplus\basic;

/**
 *
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
interface UserConfirmableInterface extends EmailableInterface{
    
    public function isConfirmed();
    
    public function resendConfirmation();
    
    public function confirm();
    
    public function generateConfirmToken();
    
    public static function findIdentityByConfirmToken($token);
    
}
