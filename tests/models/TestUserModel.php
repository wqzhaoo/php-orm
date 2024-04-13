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
use EasySwoole\ORM\Db\Cursor;
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
class TestUserModel extends AbstractModel
{
    protected $tableName = 'test_user_model';

    public function __construct(array $data = [])
    {
        $connectionName = $this->getConnectionName();
        $con = DbManager::getInstance()->getConnection($connectionName);
        if ($con->getConfig()->isFetchMode()) {
            $sql = "SHOW TABLES LIKE '{$this->tableName}';";
            $query = new QueryBuilder();
            $query->raw($sql);
            $result = DbManager::getInstance()->query($query)->getResult();
            if ($result instanceof Cursor) {
                $result = $result->getStatement()->fetchAll();
            }
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
                $result = DbManager::getInstance()->query($query)->getResult();
                if ($result instanceof Cursor) {
                    $result->getStatement()->fetchAll();
                }
            }
        }

        parent::__construct($data);
    }
}
