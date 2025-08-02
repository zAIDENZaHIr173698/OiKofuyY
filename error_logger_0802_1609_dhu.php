<?php
// 代码生成时间: 2025-08-02 16:09:40
// ErrorLogger.php
// 错误日志收集器类，用于记录和处理PHP错误日志

class ErrorLogger {
    // 错误日志文件路径
    private $logFile;

    // 构造函数
    public function __construct($logFilePath) {
        $this->logFile = $logFilePath;
    }

    // 设置错误日志文件路径
    public function setLogFile($logFilePath) {
        $this->logFile = $logFilePath;
    }

    // 获取错误日志文件路径
    public function getLogFile() {
        return $this->logFile;
    }

    // 错误处理函数
    public function handleError($errno, $errstr, $errfile, $errline) {
        if (!(error_reporting() & $errno)) {
            // 这个错误级别没有被设置为报告，忽略它
            return;
        }

        // 创建错误日志消息
        $errorLogMessage = "Error [{$errno}]: {$errstr} in {$errfile} on line {$errline}
";

        // 将错误日志消息写入文件
        $errorLogMessage = date("Y-m-d H:i:s") . " - " . $errorLogMessage;
        $this->writeLog($errorLogMessage);
    }

    // 异常处理函数
    public function handleException($exception) {
        $errorLogMessage = "Uncaught exception: " . $exception->getMessage() . " in " . $exception->getFile() . " on line " . $exception->getLine() . "
";
        $errorLogMessage = date("Y-m-d H:i:s") . " - " . $errorLogMessage;
        $this->writeLog($errorLogMessage);
    }

    // 将日志消息写入文件
    private function writeLog($logMessage) {
        if (file_exists($this->logFile)) {
            file_put_contents($this->logFile, $logMessage, FILE_APPEND);
        } else {
            file_put_contents($this->logFile, $logMessage);
        }
    }
}

// 设置错误处理和异常处理
$logFilePath = "error_log.txt";
$errorLogger = new ErrorLogger($logFilePath);
set_error_handler(["ErrorLogger", 'handleError']);
set_exception_handler(["ErrorLogger", 'handleException']);

// 使用示例
try {
    // 触发一个错误
    trigger_error('这是一个用户警告', E_USER_WARNING);
    // 触发一个异常
    throw new Exception('这是一个未捕获的异常');
} catch (Exception $e) {
    // 异常被捕获，已经被ErrorLogger处理
}
