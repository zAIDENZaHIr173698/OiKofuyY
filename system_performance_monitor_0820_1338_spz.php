<?php
// 代码生成时间: 2025-08-20 13:38:59
class SystemPerformanceMonitor {

    /**
     * Retrieves the current memory usage in bytes.
     *
     * @return float
     */
    public function getMemoryUsage() {
        $memoryUsage = memory_get_usage();
        return $memoryUsage;
    }

    /**
     * Retrieves the current CPU usage as a percentage.
     *
     * @return float
     */
    public function getCpuUsage() {
        $cpuUsage = 0.0;
        if (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();
            $cpuUsage = $load[0] * 100;
        }
        return $cpuUsage;
    }

    /**
     * Displays the system performance report.
     *
     * @return string
     */
    public function displayReport() {
        $memoryUsage = $this->getMemoryUsage();
        $cpuUsage = $this->getCpuUsage();

        return "System Performance Report:
" .
               "Memory Usage: " . $memoryUsage . " bytes
" .
               "CPU Usage: " . number_format($cpuUsage, 2) . "%";
    }
}

// Usage example
try {
    $monitor = new SystemPerformanceMonitor();
    echo $monitor->displayReport();
} catch (Exception $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage();
}
