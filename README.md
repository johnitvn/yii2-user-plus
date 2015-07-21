#yii2-rbac-plus
=============
[![Latest Stable Version](https://poser.pugx.org/{package}/v/stable)](https://packagist.org/packages/{package})
[![License](https://poser.pugx.org/{package}/license)](https://packagist.org/packages/{package})
[![Total Downloads](https://poser.pugx.org/{package}/downloads)](https://packagist.org/packages/{package})
[![Monthly Downloads](https://poser.pugx.org/{package}/d/monthly)](https://packagist.org/packages/{package})
[![Daily Downloads](https://poser.pugx.org/{package}/d/daily)](https://packagist.org/packages/{package})

High flexible user management extension for yii2


Features
------------
+ 

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist {package} "*"
```

or add

```
"{package}": "*"
```

to the require section of your `composer.json` file.


Usage
-----
User Plus provider 3 modules(simple,basic and advanced).
Per module contain one concept for handler user management workflow. 
You must understanding concept of three module.

#####1. Simple Module:
   As name of module, it useful for simple business. 
   The feature of this module is:
+ User login handler(You can choose login is username/email)
+ User register handler(You can enable/disable user register)
+ User logout handler
+ CRUD operations for user management
+ Create administrator( Just accept create administrator from command)

<b>When do you should use simple module</b>
+ You have simple business with user flow
+ You don't need register confirmation function 
+ Example: You have backend application for manager products. So you just need login feature and don't need user register.
So simple module is best choice for you

######2. Basic Module:
   Basic module contain all features of simple module and following below
+ After user register, application will send an email to user. And user must go to confirm link in email to confirm their account.
+ You can disable/enable confirmation feature
+ You can disable/enable unconfirmed user login, too
+ Additionally user can recovery password via email
+ You can disable/enable recovery password function
+ Because user confirmation and recovery password need send email to user. So this module required user register with username, email and password. You sill can choose login with email/username like simple module

######3. Advance Module:
  Advance Module requirement is developing. It's will coming soon.


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


