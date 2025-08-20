<?php
// 代码生成时间: 2025-08-21 02:52:52
class RandomNumberGenerator {

    /**
     * Generate a random number within a specified range.
     *
     * @param int $min The minimum value of the range.
     * @param int $max The maximum value of the range.
     * @return int The generated random number.
     * @throws InvalidArgumentException If the minimum or maximum values are invalid.
     */
    public function generate($min, $max) {
        // Check if the minimum value is less than the maximum value
        if ($min > $max) {
            throw new InvalidArgumentException('Minimum value cannot be greater than maximum value.');
        }

        // Check if the values are integers
        if (!is_int($min) || !is_int($max)) {
            throw new InvalidArgumentException('Minimum and maximum values must be integers.');
        }

        // Generate and return the random number
        return rand($min, $max);
    }
}

// Usage example
try {
    $generator = new RandomNumberGenerator();
    $randomNumber = $generator->generate(1, 100);
    echo "Generated random number: $randomNumber";
} catch (InvalidArgumentException $e) {
    echo "Error: " . $e->getMessage();
}
