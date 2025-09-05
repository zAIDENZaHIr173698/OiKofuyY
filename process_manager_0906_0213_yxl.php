<?php
// 代码生成时间: 2025-09-06 02:13:51
class ProcessManager {

    /**
     * List all running processes
     *
     * @return array
     */
    public function listProcesses() {
        try {
            // Execute 'ps' command to list all processes
            $output = [];
            exec('ps aux', $output);
            return $output;
        } catch (Exception $e) {
            // Handle any exceptions that occur during process listing
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Start a new process
     *
     * @param string $command Command to execute
     * @return bool
     */
    public function startProcess($command) {
        try {
            // Execute the given command to start a new process
            exec($command . ' > /dev/null &', $output, $return_var);
            if ($return_var === 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            // Handle any exceptions that occur during process start
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Stop a process by its PID
     *
     * @param int $pid Process ID
     * @return bool
     */
    public function stopProcess($pid) {
        try {
            // Send SIGTERM to the process to terminate it gracefully
            exec('kill ' . $pid, $output, $return_var);
            if ($return_var === 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            // Handle any exceptions that occur during process stop
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Restart a process by stopping and then starting it
     *
     * @param int $pid Process ID
     * @param string $command Command to restart
     * @return bool
     */
    public function restartProcess($pid, $command) {
        try {
            // First, stop the process
            if ($this->stopProcess($pid)) {
                // Then, start the process again
                return $this->startProcess($command);
            } else {
                return false;
            }
        } catch (Exception $e) {
            // Handle any exceptions that occur during process restart
            return ['error' => $e->getMessage()];
        }
    }
}
