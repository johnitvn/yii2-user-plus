<?php
namespace johnitvn\userplus;

use Yii;
use yii\base\BootstrapInterface;

/**
* Hook with application bootstrap stage
* @author John Martin <john.itvn@gmail.com>
* @since 1.0.0
*/
class Bootstrap implements BootstrapInterface
{
    
    /**
    * Initial application compoments and modules need for extension
    * @param \yii\base\Application $app The application currently running
    * @return void
    */
    public function bootstrap($app){  

        // Set alias for extension source
        Yii::setAlias("@userplus","@vendor/johnitvn/yii2-user-plus/src");

        // Setup i18n compoment for translate all category user*
        if (!isset(Yii::$app->get('i18n')->translations['user*'])) {
            Yii::$app->get('i18n')->translations['user*'] = [
                'class'    => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
            ];
        }
        
    }

   
}
