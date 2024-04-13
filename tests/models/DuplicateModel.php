<?php
/**
 * @author gaobinzhan <gaobinzhan@gmail.com>
 */


namespace EasySwoole\ORM\Tests\models;


use EasySwoole\DDL\Blueprint\Table;
use EasySwoole\Mysqli\QueryBuilder;
use EasySwoole\ORM\AbstractModel;
use EasySwoole\ORM\DbManager;

class DuplicateModel extends AbstractModel
{
    protected $tableName = 'duplicate';

    protected $autoTimeStamp = false;

    public function __construct(array $data = [])
    {
        $sql = "SHOW TABLES LIKE '{$this->tableName}';";
        $query = new QueryBuilder();
        $query->raw($sql);
        $result = DbManager::getInstance()->query($query)->getResult();
        if (empty($result)) {
            $table = new Table($this->tableName);
            $table->setIfNotExists();
            $table->int('id');
            $table->int('id1');
            $table->char('nickname', 30);
            $table->char('nickname1', 30);
            $table->primary('id', ['id', 'id1']);

            $query = new QueryBuilder();
            $query->raw($table->__toString());
            DbManager::getInstance()->query($query);
        }

        parent::__construct($data);
    }
}
