Usage
-----

1. Console commands:
You only can manager user when your account is administrator.
So you must create administrator via command user/create-admin in the fist.
And after that you can login and manager user. You also can set administrator to other user when your account is administrator.

````bash
$ yii
- user                         User manager commands
    user/create-admin          Create new administrator account.
````

Now let run console command. And enter your account information.
 
```bash
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