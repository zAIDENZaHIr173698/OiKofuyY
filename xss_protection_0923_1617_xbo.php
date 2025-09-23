<?php
// 代码生成时间: 2025-09-23 16:17:45
 * It is designed to be easily maintainable and extensible for future needs.
 */
class XssProtection {

    private $allowedTags = ['b', 'i', 'u', 'p', 'br', 'strong', 'em', 'span'];

    /**
     * Constructor
     *
     * Initializes the allowed tags array.
     */
    public function __construct() {
        // Initialize allowed tags
    }

    /**
     * Sanitize Input
     *
     * This method sanitizes user input to prevent XSS attacks.
     *
     * @param string $input The user input to be sanitized.
     * @return string Sanitized input.
     */
    public function sanitizeInput($input) {
        try {
            // Remove any script tags from the input
            $input = $this->removeScriptTags($input);

            // Convert special characters to HTML entities
            $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');

            // Allow only specified tags
            $input = $this->allowOnlyCertainTags($input);

            return $input;
        } catch (Exception $e) {
            // Handle any exceptions that occur during sanitization
            error_log('Error sanitizing input: ' . $e->getMessage());
            return '';
        }
    }

    /**
     * Remove Script Tags
     *
     * This method removes all script tags from the input.
     *
     * @param string $input The input to remove script tags from.
     * @return string Input without script tags.
     */
    private function removeScriptTags($input) {
        return preg_replace('/<script\b[^<]*(?:(?!</script>)<[^<]*)*</script>/i', '', $input);
    }

    /**
     * Allow Only Certain Tags
     *
     * This method allows only certain tags in the input.
     *
     * @param string $input The input to filter tags from.
     * @return string Input with only allowed tags.
     */
    private function allowOnlyCertainTags($input) {
        // Create an allowed tags string
        $allowedTagsString = implode('', array_map(function ($tag) {
            return '<' . $tag . '\b[^<]*>';
        }, $this->allowedTags));

        // Remove all tags not in the allowed tags string
        $input = preg_replace('/<(?!/?(' . $allowedTagsString . '))[^>]*>/', '', $input);

        return $input;
    }

}

// Usage example
$xssProtection = new XssProtection();
$unsafeInput = '<script>alert(1)</script>';
$safeInput = $xssProtection->sanitizeInput($unsafeInput);

// Output the sanitized input
echo $safeInput;