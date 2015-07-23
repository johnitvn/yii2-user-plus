Configuration for simple module
---

List of simple module config variable avaiable:

+ <b>rememberFor(integer)</b>: Time to remember user login. <BR>
Default time rememberFor is 3600*24(1 day). You can set 0 to disable remember user login feature. And you must set `'enableAutoLogin' => true` in the user component config to enable remember user login
+ <b>enableRegister(boolean)</b>:  Enable user register. <BR>
Default user register is disable.
+ <b>modelMap(array)</b>: Array of model mapping.
+ <b>enableSecurityHandler(boolean)</b>: Enable/Disable security controller. 
Default security handler is true. So you can access to routes `/user/security/*`

