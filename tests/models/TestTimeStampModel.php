<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/3 0003
 * Time: 0:04
 */

namespace EasySwoole\ORM\Tests\models;


use EasySwoole\Mysqli\QueryBuilder;
use EasySwoole\ORM\AbstractModel;
use EasySwoole\ORM\DbManager;
use EasySwoole\ORM\Utility\Schema\Table;

/**
 * Class TestTimeStampModel
 *
 * @package EasySwoole\ORM\Tests
 * @property mixed $id
 * @property mixed $name
 * @property mixed $age
 * @property mixed $create_at
 * @property mixed $update_at
 * @property mixed $create_time
 * @property mixed $update_time
 */
class TestTimeStampModel extends AbstractModel
{
    protected $tableName = 'tiamstamp_test';

    protected $autoTimeStamp = true;
    protected $createTime = 'create_at';
    protected $updateTime = 'update_at';

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
            $tableDDL->colDateTime('create_time')->setIsNotNull(false);
            $tableDDL->colDateTime('update_time')->setIsNotNull(false);
            $tableDDL->colInt('create_at', 10)->setIsNotNull(false);
            $tableDDL->colInt('update_at', 10)->setIsNotNull(false);
            $tableDDL->setIfNotExists();

            $sql = $tableDDL->__createDDL();
            $query->raw($sql);
            DbManager::getInstance()->query($query);
        }

        parent::__construct($data);
    }

    public function setAutoTime($value)
    {
        $this->autoTimeStamp = $value;
    }

    public function setCreateTime($value)
    {
        $this->createTime = $value;
    }

    public function setUpdateTime($value)
    {
        $this->updateTime = $value;
    }
}
