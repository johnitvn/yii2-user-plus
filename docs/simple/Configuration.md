Configuration for simple module
---

List of simple module config variable avaiable:

+ <b>rememberFor(integer)</b>: Time to remember user login. <BR>
  + Default time rememberFor is 3600*24(1 day). 
  + You must set `rememberFor=0` or `enableAutoLogin=false` in the user component config to disable remember user login feature. 
  + You must set `rememberFor>0`  or `enableAutoLogin=true` in the user component config to enable remember user login feature.
+ <b>enableRegister(boolean)</b>:  Enable user register. <BR>
Default user register is disable.
+ <b>modelMap(array)</b>: Array of model mapping.<BR>
Default list of model map for simple module is
````php
  [
    'UserSearch' => 'johnitvn\userplus\simple\models\UserSearch',
    'UserAccounts' => 'johnitvn\userplus\simple\models\UserAccounts',
    'LoginForm' => 'johnitvn\userplus\simple\models\LoginForm',
    'RegisterForm' => 'johnitvn\userplus\simple\models\RegisterForm',
    'ChangePasswordForm' => 'johnitvn\userplus\simple\models\ChangePasswordForm',
  ]
````
+ <b>enableSecurityHandler(boolean)</b>: Enable/Disable security controller. 
Default security handler is true. So you can access to routes `/user/security/*`

