#yii2-rbac-plus
=============
[![Latest Stable Version](https://poser.pugx.org/johnitvn/yii2-user-plus/v/stable)](https://packagist.org/packages/johnitvn/yii2-user-plus)
[![License](https://poser.pugx.org/johnitvn/yii2-user-plus/license)](https://packagist.org/packages/johnitvn/yii2-user-plus)
[![Total Downloads](https://poser.pugx.org/johnitvn/yii2-user-plus/downloads)](https://packagist.org/packages/johnitvn/yii2-user-plus)
[![Monthly Downloads](https://poser.pugx.org/johnitvn/yii2-user-plus/d/monthly)](https://packagist.org/packages/johnitvn/yii2-user-plus)
[![Daily Downloads](https://poser.pugx.org/johnitvn/yii2-user-plus/d/daily)](https://packagist.org/packages/johnitvn/yii2-user-plus)

High flexible user management extension for yii2


Features
------------
+ 

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist johnitvn/yii2-user-plus "*"
```

or add

```
"johnitvn/yii2-user-plus": "*"
```

to the require section of your `composer.json` file.


Modules business concept
-----
User Plus provider 3 modules(simple,basic and advanced).
Per module contain one concept for handler user management workflow. 
You must understanding concept of three module.

#####1. Simple Module:
###### As name of module, it useful for simple business. 
The feature of this module is:
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
(Updating)

#####3. Advance Module:
  Advance Module requirement is developing. It's will coming soon.



Installation
-----
After you choose module business you want. Now, go to configuration.

1. The first add to web config following below:
````
'modules'=>[
    'user'=>[
        'class'=>'johnitvn\userplus\{{ModuleName}}\Module',
        // You can add other config after
    ]
],
'components'=>[
    'user' => [
        'identityClass' => 'johnitvn\userplus\{{ModuleName}}\models\UserAccount',
    ],
]
````
Let replace `{{ModuleName}}` to simple or basic or advanced 

2. Next, add to console config following bellow:
````
'modules'=>[
    'user'=>'johnitvn\userplus\{{ModuleName}}\Module',
],
'components'=>[
    'user' => [
        'class'=>'yii\web\User',
        'identityClass' => 'johnitvn\userplus\{{ModuleName}}\models\UserAccount',
        'loginUrl'=>'/user/security/login'
    ],
]
````

3. The last thing is run the migrate command
````
$ yii migrate/up -migrationPath=@userplus/migrations
````

Usage
-----

1. Console commands:
You only can manager user when your account is administrator.
So you must create administrator via command user/create-admin in the fist.
And after that you can login and manager user. You also can set administrator to other user when your account is administrator.
````
$ yii
...
- user                         User manager commands
    user/create-admin          Create new administrator account.
...
````

Now let run console command. And enter your account information. 
```
$ yii user/create-admin
```
The information of account depending on the module you choose. 
Example for simple module you need username/email and password.
The default login field is username. You can see [Configuration] for more information

2. After create administrator you can login to application
The listing of available route is:
+ /user/security/login
+ /user/security/logout
+ /user/security/register
+ /user/manager

Some route i'm not listing here because you no need do anything with its.



##Development roadmap
#### Version 1.0.0 (Schedule release at July 20, 2015)
Features of this version:
+ Manager user
+ Registration,Signin,Signout handler
+ Recovery password handler
+ Confirmation hanler
+ Role base access control manager(File/Database config)

#### Version 1.1.0 
Features of this version:
+ All of feature in version 1.0.0
+ Social authencation 
+ User profile handler

#### Version 1.2.0
+ All of feature in lower version
+ OAuth login
+ Api for manager user


