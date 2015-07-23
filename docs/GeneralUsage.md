Usage
-----

###Console commands:
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
The default login field is username. You can see [Configuration](https://github.com/johnitvn/yii2-user-plus/tree/master/docs#2-configuration) for more information

### Listing of available route
After create administrator you can login to application , the listing of available route is:<BR>

+ /user/security/login
+ /user/security/logout
+ /user/security/register
+ /user/manager
