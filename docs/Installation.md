Installation
-----
After you choose module business you want. Now, go to configuration.

1. The first add to web config following below:
````php
'modules'=>[
    'user'=>[
        'class'=>'johnitvn\userplus\{{ModuleName}}\Module',
        // You can add other config after
    ]
],
'components'=>[
    'user' => [
        'identityClass' => 'johnitvn\userplus\{{ModuleName}}\models\UserAccounts',
    ],
]
````
Let replace `{{ModuleName}}` to simple or basic or advanced 

2. Next, add to console config following bellow:
````php
'modules'=>[
    'user'=>'johnitvn\userplus\{{ModuleName}}\Module',
],
'components'=>[
    'user' => [
        'class'=>'yii\web\User',
        'identityClass' => 'johnitvn\userplus\{{ModuleName}}\models\UserAccounts',
        'loginUrl'=>'/user/security/login'
    ],
]
````

3. The last thing is run the migrate command
````bash
$ yii migrate/up --migrationPath=@userplus/{{ModuleName}}/migrations
````

4. Additional when you want to user basic/advanced module with confirmation and recovery password feature. You must config mailer component for send email
````php
'components' => [
    'mailer' => [
        'class' => 'yii\swiftmailer\Mailer',
    ],
],
````

You can read [Yii2 mailling tutorial](http://www.yiiframework.com/doc-2.0/guide-tutorial-mailing.html) for more detail about swift mailer

This example will show to you sending email via remote smtp server (gmail)

````php
'mailer' => [
    'class' => 'yii\swiftmailer\Mailer',
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => 'localhost',
        'username' => 'username',
        'password' => 'password',
        'port' => '587',
        'encryption' => 'tls',
    ],
],
````