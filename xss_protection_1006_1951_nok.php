<?php
// 代码生成时间: 2025-10-06 19:51:46
 * It follows PHP best practices for security and code maintainability.
 */
class XssProtection {

    /**
     * Sanitize input to prevent XSS attacks.
     *
     * @param string $input The input data to sanitize.
     * @return string The sanitized input data.
     */
    public function sanitizeInput($input) {
        // Use htmlspecialchars to convert special characters to HTML entities
        $sanitizedInput = htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return $sanitizedInput;
    }

    /**
     * Escape output to prevent XSS attacks.
     *
     * @param string $output The output data to escape.
     * @return string The escaped output data.
     */
    public function escapeOutput($output) {
        // Use htmlspecialchars to convert special characters to HTML entities
        $escapedOutput = htmlspecialchars($output, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return $escapedOutput;
    }
}

// Usage example
$xssProtection = new XssProtection();

$unsafeInput = "<script>alert('XSS')</script>";
$safeInput = $xssProtection->sanitizeInput($unsafeInput);

echo $safeInput; // This will output: &lt;script&gt;alert('XSS')&lt;/script&gt;

// When rendering HTML, always escape output
$unsafeOutput = "<script>alert('XSS')</script>";
$safeOutput = $xssProtection->escapeOutput($unsafeOutput);

echo "<div>" . $safeOutput . "</div>"; // This will output: <div>&lt;script&gt;alert('XSS')&lt;/script&gt;</div>
