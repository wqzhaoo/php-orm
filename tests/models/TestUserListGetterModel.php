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
 *
 * @package EasySwoole\ORM\Tests
 * @property $id
 * @property $name
 * @property $age
 * @property $addTime
 * @property $state
 */
class TestUserListGetterModel extends AbstractModel
{
    protected $tableName = 'user_test_list';

    public function __construct(array $data = [])
    {
        $sql = "SHOW TABLES LIKE '{$this->tableName}';";
        $query = new QueryBuilder();
        $query->raw($sql);
        $result = DbManager::getInstance()->query($query)->getResult();
        if (empty($result)) {
            $query = new QueryBuilder();
            $tableDDL = new Table($this->tableName);
            $tableDDL->setIfNotExists();
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

    public function getAddTimeAttr()
    {
        return 123;
    }

    public function setAddTimeAttr()
    {
        return '2019-11-2 23:48:44';
    }
}
