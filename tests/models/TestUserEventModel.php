<?php
/**
 * Created by PhpStorm.
 * User: Tioncico
 * Date: 2019/10/22 0022
 * Time: 15:08
 */

namespace EasySwoole\ORM\Tests\models;


use EasySwoole\DDL\Blueprint\Table;
use EasySwoole\Mysqli\QueryBuilder;
use EasySwoole\ORM\AbstractModel;
use EasySwoole\ORM\DbManager;

/**
 * Class TestUserModel
 * @package EasySwoole\ORM\Tests
 * @property $id
 * @property $name
 * @property $age
 * @property $addTime
 * @property $state
 */
class TestUserEventModel extends AbstractModel
{
    protected $tableName = 'test_user_model';

    public static $insert = false;
    public static $update = false;
    public static $delete = false;

    public function __construct(array $data = [])
    {
        $sql = "SHOW TABLES LIKE '{$this->tableName}';";
        $query = new QueryBuilder();
        $query->raw($sql);
        $result = DbManager::getInstance()->query($query)->getResult();
        if (empty($result)) {
            $tableDDL = new Table($this->tableName);
            $tableDDL->colInt('id', 11)->setIsPrimaryKey()->setIsAutoIncrement();
            $tableDDL->colVarChar('name', 255);
            $tableDDL->colTinyInt('age', 1);
            $tableDDL->colDateTime('addTime');
            $tableDDL->colTinyInt('state', 1);
            $tableDDL->setIfNotExists();
            $sql = $tableDDL->__createDDL();
            $query->raw($sql);
            DbManager::getInstance()->query($query);
        }

        parent::__construct($data);
    }

    protected static function onBeforeInsert($model)
    {
        return self::$insert;
    }

    protected static function onAfterInsert($model, $res)
    {

    }

    protected static function onBeforeUpdate($model)
    {
        return self::$update;
    }

    protected static function onAfterUpdate($model, $res)
    {

    }

    protected static function onBeforeDelete()
    {
        return self::$delete;
    }

    public static function onAfterDelete($model, $res)
    {

    }
}
