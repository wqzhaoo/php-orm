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

class Users extends AbstractModel
{
    protected $tableName = 'users';

    public function __construct(array $data = [])
    {
        $sql = "SHOW TABLES LIKE '{$this->tableName}';";
        $query = new QueryBuilder();
        $query->raw($sql);
        $result = DbManager::getInstance()->query($query)->getResult();
        if (empty($result)) {
            $tableDDL = new Table($this->tableName);
            $tableDDL->colInt('user_id', 11)->setIsPrimaryKey()->setIsAutoIncrement();
            $tableDDL->colVarChar('name', 255);
            $tableDDL->setIfNotExists();
            $sql = $tableDDL->__createDDL();
            $query->raw($sql);
            DbManager::getInstance()->query($query);
        }

        parent::__construct($data);
    }

    public function roles()
    {
        return $this->belongsToMany(Roles::class, 'user_role');
    }

    public function roles_join()
    {
        return $this->belongsToMany(Roles::class, 'user_role', 'user_id', 'user_id');
    }

    public function roles_different_field()
    {
        return $this->belongsToMany(Roles::class, 'user_role_different_field', 'u_id', 'r_id');
    }

    public function roles_different_field_call()
    {
        return $this->belongsToMany(Roles::class, 'user_role_different_field', 'u_id', 'r_id', function (QueryBuilder $builder) {
            // 是目标表
            $builder->fields("role_id");
        });
    }
}
