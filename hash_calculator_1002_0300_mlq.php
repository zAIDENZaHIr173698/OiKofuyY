<?php
// 代码生成时间: 2025-10-02 03:00:22
class HashCalculator {

    private $algorithm;

    /**
     * Constructor to set the algorithm for hashing.
     *
     * @param string $algorithm The hashing algorithm to use.
     */
    public function __construct($algorithm = 'md5') {
        $this->algorithm = $algorithm;
    }

    /**
     * Sets the hashing algorithm.
     *
     * @param string $algorithm The hashing algorithm to use.
     */
    public function setAlgorithm($algorithm) {
        $this->algorithm = $algorithm;
    }

    /**
     * Calculates the hash of the given string.
     *
     * @param string $string The string to hash.
     * @return string The calculated hash value.
     * @throws Exception If the algorithm is not supported.
     */
    public function calculateHash($string) {
        // Check if the algorithm is supported
        if (!in_array($this->algorithm, hash_algos(), true)) {
            throw new Exception("Unsupported hashing algorithm: {$this->algorithm}");
        }

        // Calculate the hash
        return hash($this->algorithm, $string);
    }
}

// Example usage
try {
    $hashCalculator = new HashCalculator('sha256');
    $inputString = "Hello, World!";
    $hashValue = $hashCalculator->calculateHash($inputString);
    echo "The hash value is: " . $hashValue;
} catch (Exception $e) {
    // Error handling
    echo "Error: " . $e->getMessage();
}
