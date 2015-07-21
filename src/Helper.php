<?php
namespace johnitvn\userplus;

/**
 * The helper class contain helper functions
 *
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class Helper {

    /**
     * Dump expression with PRE tag
     * @param mixed $expression The expression want to dump
     * @param bool $die exit application after dump or not
     * @return void
     * @see http://php.net/manual/en/function.var-dump.php
     */
    public static function dump($expression, $die = false) {
        echo '<PRE>';
        var_dump($expression);
        echo '</PRE>';
        !$die or die();
    }

    /**
     * Check is yii console application or not.
     * @return boolean Return true if is console application
     */
    public static function isConsoleApplication() {
        return \Yii::$app instanceof \yii\console\Application;
    }
    
    
    /**
     * Generate password
     * @return string The random password with 8 chars
     */
    public static function generatePassword(){
        return static::generateRandomString(8,false);
    }

    /**
     * Generate random string
     * @param integer $lenght The lenght of random string (Default: 32)
     * @param boolean $withTime With prefix timestamp or not
     * @param string $delimiter Delimiter string between time and random string
     * @return string Random string
     */
    public static function generateRandomString($lenght = 32, $withTime = true, $delimiter = "$") {
        if ($withTime) {
            $time = strval(time());
            $rString = \Yii::$app->security->generateRandomString($lenght - strlen($time));
            return $time . $delimiter . $rString;
        } else {
            return \Yii::$app->security->generateRandomString($lenght);
        }
    }
    
    /**
     * 
     * @param mixed $object
     * @return string the name space of object
     */
    public static function getNamespace($object){
        $class = new \ReflectionClass($object::className());
        return $class->getNamespaceName();
    }

}
