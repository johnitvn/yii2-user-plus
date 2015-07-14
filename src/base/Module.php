<?php
namespace johnitvn\userplus\base;

use Yii;
use yii\helpers\ArrayHelper;
use johnitvn\userplus\Helper;
use yii\base\Module as YiiModule;

/**
 * The base module for all module class in <b>User Plus</b> extension
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
abstract class Module extends YiiModule {

    /**
     * @var integer Time to remember user login.
     * Default is 1 day
     */
    public $rememberFor = 3600 * 24;

    /**
     * @var boolean enableRegister Enable user register.
     * Default user register is disable
     */
    public $enableRegister = false;

    /**
     * @var array modelMap Model mapping. 
     * Use for extends module.
     */
    public $modelMap = [];
    
    /**
     * Initial module
     * @return void
     */
    public function init(){
        // Initial model map
        $this->modelMap = ArrayHelper::merge($this->getDefaultModelMap(), $this->modelMap);               
        
        // Initial controller namespace for web app and console app
        if(Helper::isConsoleApplication()){
            $this->controllerNamespace = $this->getConsoleControllerNamespace();
        }else{
            $this->controllerNamespace = $this->getWebControllerNamespace();
        }       
    }
    
    public function beforeAction($action) {
        $aId = $action->id;
        if ($aId == "register" && !$this->enableRegister) {
            throw new \yii\web\NotFoundHttpException("Page not found");
        }  else {
            return parent::beforeAction($action);
        }
    }
    
     /**
     * Return default model map for modules.
     * When user not config model for map so we will get model class
     * from this default model map
     * @return array Default model map
     */
    abstract protected function getDefaultModelMap();
    
    /**
     * Return web controller namespace.
     * @return string The web app controller namespace
     */
    abstract protected function getWebControllerNamespace();
    
    /**
     * Return console controller namespace.    
     * @return array The console app controller namespace
     */
    abstract protected function getConsoleControllerNamespace();
    
    /**
     * Get model class from model map.
     *
     * @param string $name The name of model
     * @return string The model's class
     * 
     * @see Module::$modelMap
     */
    public function getModelClassName($name) {
        return $this->modelMap[$name];
    }
    
    /**
     * Create instance of model with name of model and config.
     * This function will get class of model from Module::getModelClass()
     * And create instance of that class with array config input
     * @param type $name
     * @param array $config
     */
    public function createModelInstance($name,array $config = []){
         $config['class'] = $this->getModelClassName($name);
         return Yii::createObject($config);
    }
   
}
