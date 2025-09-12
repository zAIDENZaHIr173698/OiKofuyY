<?php
// 代码生成时间: 2025-09-12 10:06:53
 * Form Validator using PHP and ZF (Zend Framework)
 *
 * This class provides a simple form validation mechanism using Zend Framework.
 * It is designed to be easily understandable and maintainable.
 */
class FormValidator {

    /**
     * Validate email address
     *
     * @param string $email
     * @return bool
     */
    public function validateEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // If the email is not valid, return false
            return false;
        }
        return true;
    }

    /**
     * Validate non-empty string
     *
     * @param string $string
     * @return bool
     */
    public function validateNonEmptyString($string) {
        if (empty($string) || !is_string($string)) {
            // If the string is empty or not a string, return false
            return false;
        }
        return true;
    }

    /**
     * Validate integer
     *
     * @param mixed $value
     * @return bool
     */
    public function validateInteger($value) {
        if (!filter_var($value, FILTER_VALIDATE_INT)) {
            // If the value is not an integer, return false
            return false;
        }
        return true;
    }

    /**
     * Validate form data
     *
     * @param array $formData
     * @return array
     */
    public function validateFormData(array $formData) {
        $errors = [];

        // Validate email
        if (!$this->validateEmail($formData['email'] ?? '')) {
            $errors['email'] = 'Invalid email address';
        }

        // Validate username (non-empty string)
        if (!$this->validateNonEmptyString($formData['username'] ?? '')) {
            $errors['username'] = 'Username cannot be empty';
        }

        // Validate age (integer)
        if (!$this->validateInteger($formData['age'] ?? null)) {
            $errors['age'] = 'Invalid age. Please enter a valid integer.';
        }

        return $errors;
    }

}

// Example usage
$validator = new FormValidator();
$formData = [
    'email' => 'test@example.com',
    'username' => 'johndoe',
    'age' => '30'
];

$errors = $validator->validateFormData($formData);

if (empty($errors)) {
    echo 'Form data is valid';
} else {
    echo 'Form data has errors:';
    print_r($errors);
}
