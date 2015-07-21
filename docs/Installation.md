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
        'identityClass' => 'johnitvn\userplus\{{ModuleName}}\models\UserAccounts',
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
        'identityClass' => 'johnitvn\userplus\{{ModuleName}}\models\UserAccounts',
        'loginUrl'=>'/user/security/login'
    ],
]
````

3. The last thing is run the migrate command
````
$ yii migrate/up -migrationPath=@userplus/migrations
````