<?php
// 代码生成时间: 2025-09-23 11:58:10
class XssProtection {

    /**
     * Sanitize input to prevent XSS attacks.
     *
     * @param string $input The user input to be sanitized.
     * @return string Sanitized input.
     */
    public function sanitizeInput($input) {
        // Use ENT_QUOTES to convert special characters to HTML entities
        $sanitizedInput = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');

        // Return the sanitized input
        return $sanitizedInput;
    }

    /**
     * Sanitize array of inputs to prevent XSS attacks.
     *
     * @param array $inputArray The array of user inputs to be sanitized.
     * @return array Sanitized inputs.
     */
    public function sanitizeInputArray($inputArray) {
        $sanitizedArray = array();

        // Sanitize each input in the array
        foreach ($inputArray as $key => $value) {
            if (is_array($value)) {
                // Recursively sanitize array elements
                $sanitizedArray[$key] = $this->sanitizeInputArray($value);
            } else {
                $sanitizedArray[$key] = $this->sanitizeInput($value);
            }
        }

        // Return the sanitized array
        return $sanitizedArray;
    }
}

/**
 * Usage example
 */
try {
    $xssProtection = new XssProtection();

    // Sanitize a single input
    $userInput = "<script>alert('XSS')</script>";
    $sanitizedInput = $xssProtection->sanitizeInput($userInput);
    echo "Sanitized Input: " . $sanitizedInput;

    // Sanitize an array of inputs
    $userInputs = array(
        "input1" => "<script>alert('XSS')</script>",
        "input2" => "<a href='javascript:alert("XSS");'>Click me</a>"
    );
    $sanitizedInputs = $xssProtection->sanitizeInputArray($userInputs);
    print_r($sanitizedInputs);
} catch (Exception $e) {
    // Handle any exceptions
    echo "Error: " . $e->getMessage();
}
