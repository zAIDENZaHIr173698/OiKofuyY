<?php
// 代码生成时间: 2025-10-03 19:06:46
// 引入Zend框架的组件
require_once 'vendor/autoload.php';

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\TableGateway\TableGateway;

// 定义学习资源库的类
class LearningResourceLibrary {
    private $dbAdapter;

    // 构造函数，注入数据库适配器
    public function __construct(AdapterInterface $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

    // 获取所有学习资源的方法
    public function getAllResources() {
        try {
            $sql = 'SELECT * FROM learning_resources';
            $statement = $this->dbAdapter->query($sql);
            $results = $statement->execute();

            return $results;
        } catch (Exception $e) {
            // 错误处理
            error_log($e->getMessage());
            return false;
        }
    }

    // 添加新的学习资源
    public function addResource($resourceData) {
        try {
            $tableName = 'learning_resources';
            $tableGateway = new TableGateway($tableName, $this->dbAdapter);
            $result = $tableGateway->insert($resourceData);

            return $result;
        } catch (Exception $e) {
            // 错误处理
            error_log($e->getMessage());
            return false;
        }
    }

    // 更新现有的学习资源
    public function updateResource($resourceId, $newData) {
        try {
            $tableName = 'learning_resources';
            $tableGateway = new TableGateway($tableName, $this->dbAdapter);
            $result = $tableGateway->update($newData, ['id' => $resourceId]);

            return $result;
        } catch (Exception $e) {
            // 错误处理
            error_log($e->getMessage());
            return false;
        }
    }

    // 删除学习资源
    public function deleteResource($resourceId) {
        try {
            $tableName = 'learning_resources';
            $tableGateway = new TableGateway($tableName, $this->dbAdapter);
            $result = $tableGateway->delete(['id' => $resourceId]);

            return $result;
        } catch (Exception $e) {
            // 错误处理
            error_log($e->getMessage());
            return false;
        }
    }
}

// 以下是使用示例
// 假设你已经配置好了数据库适配器并注入到LearningResourceLibrary类中
// $dbAdapter = new Adapter([...]);
// $library = new LearningResourceLibrary($dbAdapter);

// 获取所有学习资源
// $allResources = $library->getAllResources();

// 添加新的学习资源
// $newResource = ['title' => 'New Resource', 'description' => 'Description of new resource'];
// $library->addResource($newResource);

// 更新学习资源
// $updatedResource = ['title' => 'Updated Title'];
// $library->updateResource(1, $updatedResource);

// 删除学习资源
// $library->deleteResource(1);
