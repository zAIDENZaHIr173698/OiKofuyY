<?php
// 代码生成时间: 2025-10-10 02:15:29
class MathCalculatorService {

    /**
     * Add two numbers.
     *
     * @param float $a
     * @param float $b
     * @return float
     */
    public function add($a, $b) {
        return $a + $b;
    }

    /**
     * Subtract two numbers.
     *
     * @param float $a
     * @param float $b
     * @return float
     */
    public function subtract($a, $b) {
        return $a - $b;
    }

    /**
     * Multiply two numbers.
     *
     * @param float $a
     * @param float $b
     * @return float
     */
    public function multiply($a, $b) {
        return $a * $b;
    }

    /**
     * Divide two numbers.
     *
     * @param float $a
     * @param float $b
     * @return float
     */
    public function divide($a, $b) {
        if ($b == 0) {
            throw new InvalidArgumentException('Division by zero is not allowed.');
        }
        return $a / $b;
    }

    /**
     * Calculate the modulus of two numbers.
     *
     * @param float $a
     * @param float $b
     * @return float
     */
    public function modulus($a, $b) {
        if ($b == 0) {
            throw new InvalidArgumentException('Modulus by zero is not allowed.');
        }
        return $a % $b;
    }

    /**
     * Calculate the power of a number.
     *
     * @param float $base
     * @param float $exponent
     * @return float
     */
    public function power($base, $exponent) {
        return pow($base, $exponent);
    }

    /**
     * Calculate the square root of a number.
     *
     * @param float $number
     * @return float
     */
    public function squareRoot($number) {
        if ($number < 0) {
            throw new InvalidArgumentException('Square root of negative number is not supported.');
        }
        return sqrt($number);
    }
}
