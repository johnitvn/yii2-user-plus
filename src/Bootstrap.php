<?php

namespace johnitvn\userplus;

use Yii;
use yii\base\BootstrapInterface;

/**
 * Hook with application bootstrap stage
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class Bootstrap implements BootstrapInterface {

    /**
     * Initial application compoments and modules need for extension
     * @param \yii\base\Application $app The application currently running
     * @return void
     */
    public function bootstrap($app) {
        if (Yii::$app->hasModule('user')) {

            // Set alias for extension source
            Yii::setAlias("@userplus", __DIR__);
            Yii::setAlias("@johnitvn/userplus", __DIR__);

            // Setup i18n compoment for translate all category user*
            if (!isset(Yii::$app->get('i18n')->translations['user*'])) {
                Yii::$app->get('i18n')->translations['user*'] = [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => __DIR__ . '/messages',
                ];
            }


            if (Helper::isConsoleApplication()) {
                $module = Yii::$app->getModule('user');
                // Mapping command controller
                foreach ($module->getCommandControllerMap() as $key => $value) {
                    Yii::$app->controllerMap[$key] = [
                        'class' => $value,
                    ];
                }
                // Don't catch all controller with its namespace
                $module->controllerNamespace = 'johnitvn\userplus\fake';
            }

            if (Yii::$app->hasModule('rbac')) {
                $rbacModule = Yii::$app->getModule('rbac');             
                if (get_class($rbacModule) === 'johnitvn\rbacplus\Module') {
                    $rbacModule->beforeCreateController = [$this, 'beforeRbacCreateController'];
                }
            }
        }
    }

    /**
     * Config for intergrate with Rbac plus extension
     * @param string $route
     * @return boolean
     * @throws \yii\web\ForbiddenHttpException
     */
    public function beforeRbacCreateController($route) {
        $user = Yii::$app->user;
        if ($user->isGuest || !$user->identity->isAdministrator()) {
            throw new \yii\web\ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
        return true;
    }

}
