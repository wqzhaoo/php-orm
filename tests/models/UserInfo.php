<?php
/**
 * This file is part of EasySwoole.
 *
 * @link    https://www.easyswoole.com
 * @document https://www.easyswoole.com
 * @contact https://www.easyswoole.com/Preface/contact.html
 * @license https://github.com/easy-swoole/easyswoole/blob/3.x/LICENSE
 */

namespace EasySwoole\ORM\Tests\models;

use EasySwoole\DDL\Blueprint\Table;
use EasySwoole\Mysqli\QueryBuilder;
use EasySwoole\ORM\AbstractModel;
use EasySwoole\ORM\DbManager;

class UserInfo extends AbstractModel
{
    protected $tableName = 'user_info';

    public function __construct(array $data = [])
    {
        $sql = "SHOW TABLES LIKE '{$this->tableName}';";
        $query = new QueryBuilder();
        $query->raw($sql);
        $result = DbManager::getInstance()->query($query)->getResult();
        if (empty($result)) {
            $tableDDL = new Table($this->tableName);
            $tableDDL->colInt('id', 11)->setIsPrimaryKey()->setIsAutoIncrement();
            $tableDDL->colInt('user_id', 11);
            $tableDDL->colVarChar('user_email', 255);
            $tableDDL->setIfNotExists();
            $sql = $tableDDL->__createDDL();
            $query->raw($sql);
            DbManager::getInstance()->query($query);
        }

        parent::__construct($data);
    }
}
