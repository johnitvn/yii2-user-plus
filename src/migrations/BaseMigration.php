<?php
namespace johnitvn\userplus\migrations;

use Yii;

/**
 * @author John Martin <john.itvn@gmail.com>
 */
class BaseMigration extends \yii\db\Migration
{
    /**
     * @var string
     */
    protected $tableOptions;
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        switch (Yii::$app->db->driverName) {
            case 'mysql':
                $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
                break;
            case 'pgsql':
            
                $this->tableOptions = null;
                break;
            default:
                throw new \RuntimeException('Your database is not supported!');
        }
    }
}