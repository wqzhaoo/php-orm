<?php
/**
 * Created by PhpStorm.
 * User: Siam
 * Date: 2020/2/27
 * Time: 10:01
 */

namespace EasySwoole\ORM\Tests\models;


use EasySwoole\DDL\Blueprint\Table;
use EasySwoole\Mysqli\QueryBuilder;
use EasySwoole\ORM\AbstractModel;
use EasySwoole\ORM\DbManager;

class Roles extends AbstractModel
{
    protected $tableName = 'roles';

    public function __construct(array $data = [])
    {
        $sql = "SHOW TABLES LIKE '{$this->tableName}';";
        $query = new QueryBuilder();
        $query->raw($sql);
        $result = DbManager::getInstance()->query($query)->getResult();
        if (empty($result)) {
            $tableDDL = new Table($this->tableName);
            $tableDDL->colInt('role_id', 11)->setIsPrimaryKey()->setIsAutoIncrement();
            $tableDDL->colVarChar('role_name', 255);
            $tableDDL->setIfNotExists();
            $sql = $tableDDL->__createDDL();
            $query->raw($sql);
            DbManager::getInstance()->query($query);
        }

        parent::__construct($data);
    }
}
