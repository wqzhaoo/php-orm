<?php
/**
 * @author gaobinzhan <gaobinzhan@gmail.com>
 */


namespace EasySwoole\ORM\Tests\models;


use EasySwoole\DDL\Blueprint\Table;
use EasySwoole\Mysqli\QueryBuilder;
use EasySwoole\ORM\AbstractModel;
use EasySwoole\ORM\DbManager;

class TestB extends AbstractModel
{
    protected $tableName = 'test_b';

    public function __construct(array $data = [])
    {
        $sql = "SHOW TABLES LIKE '{$this->tableName}';";
        $query = new QueryBuilder();
        $query->raw($sql);
        $result = DbManager::getInstance()->query($query)->getResult();
        if (empty($result)) {
            $tableDDL = new Table($this->tableName);
            $tableDDL->colInt('id', 11)->setIsPrimaryKey()->setIsAutoIncrement();
            $tableDDL->colInt('a_id', 11);
            $tableDDL->colVarChar('b_name', 255);
            $tableDDL->setIfNotExists();
            $sql = $tableDDL->__createDDL();
            $query = new QueryBuilder();
            $query->raw($sql);
            DbManager::getInstance()->query($query);
        }

        parent::__construct($data);
    }

    public function getBNameAttr($value, $data)
    {
        return $value . '-bar-b';
    }

    public function getCNameAttr($value, $data)
    {
        return $value . '-bar-c';
    }
}
