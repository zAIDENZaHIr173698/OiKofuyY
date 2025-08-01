<?php
// 代码生成时间: 2025-08-02 04:21:36
class ErrorLogger {

    // Error levels, based on Zend_Log
    const EMERG   = 0; // Emergency: system is unusable
    const ALERT   = 1; // Alert: action must be taken immediately
    const CRIT    = 2; // Critical: critical conditions
    const ERR     = 3; // Error: error conditions
    const WARN    = 4; // Warning: warning conditions
    const NOTICE  = 5; // Notice: normal but significant condition
    const INFO    = 6; // Informational: informational messages
    const DEBUG   = 7; // Debug: debug messages

    /**
     * @var Zend_Log The logger instance.
     */
    protected $logger;

    /**
     * Constructor for ErrorLogger.
     *
     * @param array $config Configuration array for the logger.
     */
    public function __construct(array $config) {
        // Initialize the Zend_Log instance with the provided configuration.
        $this->logger = new Zend_Log($config);
    }

    /**
     * Logs an error message with a specified level.
     *
     * @param string $message The message to log.
     * @param int $level The level of the message.
     */
    public function log($message, $level) {
        try {
            // Check if the provided level is valid.
            if (!$this->isValidLevel($level)) {
                throw new InvalidArgumentException('Invalid log level.');
            }

            // Log the message with the provided level.
            $this->logger->log($message, $level);
        } catch (Exception $e) {
            // Handle any exceptions that may occur during logging.
            // In a real-world application, this would be more robust.
            error_log('Failed to log error: ' . $e->getMessage());
        }
    }

    /**
     * Checks if the given level is valid.
     *
     * @param int $level The level to check.
     * @return bool True if valid, false otherwise.
     */
    protected function isValidLevel($level) {
        $validLevels = array(
            self::EMERG,
            self::ALERT,
            self::CRIT,
            self::ERR,
            self::WARN,
            self::NOTICE,
            self::INFO,
            self::DEBUG
        );

        return in_array($level, $validLevels);
    }
}
