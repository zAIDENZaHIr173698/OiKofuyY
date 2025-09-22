<?php
// 代码生成时间: 2025-09-22 14:04:01
// Process Manager using PHP and ZEND Framework
// This script will manage system processes, allowing the user to start, stop, and list them.

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;

class ProcessManager {
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    public function __construct(ServiceManager $serviceManager) {
        $this->serviceManager = $serviceManager;
    }

    /**
     * Start a process
     *
     * @param string $command The command to execute
     * @return void
     */
    public function startProcess($command) {
        try {
            $output = shell_exec($command);
            echo "Process started: $output\
";
        } catch (Exception $e) {
            echo "Error starting process: " . $e->getMessage() . "\
";
        }
    }

    /**
     * Stop a process by its PID
     *
     * @param int $pid The process ID
     * @return void
     */
    public function stopProcess($pid) {
        try {
            posix_kill($pid, SIGTERM);
            echo "Process $pid stopped\
";
        } catch (Exception $e) {
            echo "Error stopping process: " . $e->getMessage() . "\
";
        }
    }

    /**
     * List all running processes
     *
     * @return array
     */
    public function listProcesses() {
        $processes = [];
        $processList = shell_exec('ps aux');
        foreach (explode("\
", $processList) as $line) {
            $parts = preg_split('/\s+/', trim($line), 11);
            $processes[] = [
                'user' => $parts[0],
                'pid' => $parts[1],
                'cpu' => $parts[2],
                'mem' => $parts[3],
                'command' => implode(' ', array_slice($parts, 5)),
            ];
        }
        return $processes;
    }
}

// Usage example
$serviceManager = new ServiceManager();
$processManager = new ProcessManager($serviceManager);

// Start a new process
$processManager->startProcess('ls -la');

// Stop a process by PID
$processManager->stopProcess(1234);

// List all running processes
$processes = $processManager->listProcesses();
foreach ($processes as $process) {
    echo "PID: {$process['pid']}, Command: {$process['command']}\
";
}