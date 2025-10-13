<?php
// 代码生成时间: 2025-10-13 18:25:07
// Ensure the autoloader is included
require 'vendor/autoload.php';

// Use namespaces to organize code
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;

class SkillAuthentication
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Authenticate a user's skill
     *
     * @param string $skillName
     * @param string $userId
     * @return bool
     */
    public function authenticateSkill($skillName, $userId)
    {
        try {
            // Create a table gateway for the skills table
            $skillsTable = new TableGateway('skills', $this->adapter);

            // Select the skill from the database
            $select = new Select();
            $select->where(array('skill_name = ?' => $skillName, 'user_id = ?' => $userId));
            $resultSet = $skillsTable->selectWith($select);

            // Return true if the skill exists, false otherwise
            return count($resultSet) > 0;
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the process
            // Log the error, send an email to the admin, etc.
            error_log($e->getMessage());
            return false;
        }
    }
}

// Usage example
// Assuming you have a database adapter set up
// $dbAdapter = new Adapter($dsn);
// $skillAuth = new SkillAuthentication($dbAdapter);
// $isAuthenticated = $skillAuth->authenticateSkill('PHP', 'user123');
// if ($isAuthenticated) {
//     echo 'Skill authenticated successfully.';
// } else {
//     echo 'Skill authentication failed.';
// }
