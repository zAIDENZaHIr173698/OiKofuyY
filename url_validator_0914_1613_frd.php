<?php
// 代码生成时间: 2025-09-14 16:13:29
 * maintainability and expandability.
 */

class URLValidator {

    /**
     * Validates a given URL.
     *
     * @param string $url The URL to validate.
     * @return bool Returns true if the URL is valid, false otherwise.
     * @throws InvalidArgumentException If the URL is not a string.
     */
    public function validateURL($url) {
        // Check if the URL is a string
        if (!is_string($url)) {
            throw new InvalidArgumentException('URL must be a string.');
        }

        // Use filter_var to check if the URL is valid
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

}

// Example usage:
try {
    $urlValidator = new URLValidator();
    $url = 'https://www.example.com';
    if ($urlValidator->validateURL($url)) {
        echo 'The URL is valid.';
    } else {
        echo 'The URL is not valid.';
    }
} catch (InvalidArgumentException $e) {
    echo 'Error: ' . $e->getMessage();
}
