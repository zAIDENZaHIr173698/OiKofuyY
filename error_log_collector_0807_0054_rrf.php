<?php
// 代码生成时间: 2025-08-07 00:54:46
// 设置错误报告级别
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 引入Zend框架相关组件
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;
use Zend\Log\Filter\Priority;
use Zend\Log\Processor\Backtrace;

class ErrorLogCollector
{
    /**
     * @var Logger $logger 实例化的日志记录器
     */
    protected $logger;

    public function __construct($logFile)
    {
        // 初始化日志记录器
        $this->logger = new Logger();

        // 设置日志文件路径
        $stream = new Stream($logFile);
        $stream->setOption('mode', 'a'); // 追加模式

        // 添加日志写入器
        $this->logger->addWriter($stream);

        // 添加日志过滤器
        $filter = new Priority(Zend\Log\Logger::DEBUG);
        $this->logger->addFilter($filter);

        // 添加日志处理器
        $backtrace = new Backtrace();
        $backtrace->setOptions(['skip' => 1]); // 跳过第一个参数（即当前类）
        $this->logger->addProcessor($backtrace);
    }

    /**
     * 记录错误信息
     *
     * @param string $message 错误信息
     * @param string $priority 错误级别，默认为ERROR
     * @return void
     */
    public function logError($message, $priority = Logger::ERROR)
    {
        // 记录错误日志
        $this->logger->log($priority, $message);
    }
}

// 使用示例
try {
    // 模拟一个错误
    throw new Exception('An error occurred!');
} catch (Exception $e) {
    // 创建ErrorLogCollector实例
    $errorLogCollector = new ErrorLogCollector('error.log');

    // 记录错误信息
    $errorLogCollector->logError($e->getMessage(), Logger::ERR);
}
