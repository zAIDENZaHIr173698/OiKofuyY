<?php
// 代码生成时间: 2025-08-10 13:15:32
class XssProtection {

    /**
     * Escapes special characters in a string to prevent XSS attacks.
     *
     * @param string $input The input string to be escaped.
     * @return string The escaped string.
     */
    private function escape($input) {
        // Use htmlspecialchars to convert special characters to HTML entities
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Sanitizes user input to prevent XSS attacks.
     *
     * @param string $input The user input to be sanitized.
     * @return string The sanitized input.
     */
    public function sanitizeInput($input) {
        try {
            // Escape the input to prevent XSS attacks
            return $this->escape($input);
        } catch (Exception $e) {
            // Handle any errors that occur during the sanitization process
            error_log($e->getMessage());
            return '';
        }
    }

    /**
     * Escapes output data to prevent XSS attacks when displaying data on a webpage.
     *
     * @param string $output The output data to be escaped.
     * @return string The escaped output.
     */
    public function escapeOutput($output) {
        try {
            // Escape the output to prevent XSS attacks
            return $this->escape($output);
        } catch (Exception $e) {
            // Handle any errors that occur during the escaping process
            error_log($e->getMessage());
            return '';
        }
    }
}

// Example usage:
$xssProtection = new XssProtection();
$userInput = $_POST['user_input']; // Example user input
$sanitizedInput = $xssProtection->sanitizeInput($userInput);
echo $xssProtection->escapeOutput($sanitizedInput);
