<?php
// 代码生成时间: 2025-08-13 19:32:38
class XssProtection {

    /**
     * Sanitize data to prevent XSS attacks.
     * 
     * @param mixed $data The data to be sanitized.
     * @return mixed Sanitized data.
     */
    public static function sanitize($data) {
        if (is_array($data)) {
            // Sanitize each element of the array
            return array_map(array(__CLASS__, 'sanitize'), $data);
        } elseif (is_object($data)) {
            // Sanitize each property of the object
            foreach ($data as $key => $value) {
                $data->$key = self::sanitize($value);
            }
            return $data;
        } elseif (is_string($data)) {
            // Use htmlspecialchars to encode HTML entities
            return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        }
        return $data;
    }

    /**
     * Encode output to prevent XSS attacks.
     * 
     * @param mixed $data The data to be encoded.
     * @return string Encoded data.
     */
    public static function encode($data) {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }

}

// Example usage
try {
    // Simulate user input
    $userInput = "<script>alert('XSS')</script>";
    
    // Sanitize the input to prevent XSS attacks
    $sanitizedInput = XssProtection::sanitize($userInput);
    
    // Encode the output to prevent XSS attacks
    $encodedOutput = XssProtection::encode($sanitizedInput);
    
    // Display the sanitized and encoded output
    echo $encodedOutput;
} catch (Exception $e) {
    // Handle any errors that occur
    echo "An error occurred: " . $e->getMessage();
}