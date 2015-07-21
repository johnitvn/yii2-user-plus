Modules business concept
-----
User Plus provider 3 modules(simple,basic and advanced).
Per module contain one concept for handler user management workflow. 
You must understanding concept of three module.

#####1. Simple Module:
As name of module, it useful for simple business. 
###### The feature of this module is:
+ User login handler(You can choose login is username/email)
+ User register handler(You can enable/disable user register)
+ User logout handler
+ CRUD operations for user management
+ Create administrator( Just accept create administrator from command)

###### When do you should use simple module?
+ You have simple business with user flow
+ You don't need register confirmation function 
+ Example: You have backend application for manager products. So you just need login feature and don't need user register.
So simple module is best choice for you

#####2. Basic Module:
###### Basic module contain all features of simple module and following below
+ After user register, application will send an email to user. And user must go to confirm link in email to confirm their account.
+ You can disable/enable confirmation feature
+ You can disable/enable unconfirmed user login, too
+ Additionally user can recovery password via email
+ You can disable/enable recovery password function
+ Because user confirmation and recovery password need send email to user. So this module required user register with username, email and password. You sill can choose login with email/username like simple module

###### When do you should use simple module?
&nbsp;&nbsp;&nbsp;&nbsp;(Updating)

#####3. Advance Module:
&nbsp;&nbsp;&nbsp;&nbsp;(Developing)