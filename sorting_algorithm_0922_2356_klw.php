<?php
// 代码生成时间: 2025-09-22 23:56:32
class SortingAlgorithm {
    
    /**
     * Bubble Sort algorithm implementation
     *
     * @param array $array The array to sort
     * @return array The sorted array
     */
    public function bubbleSort(array $array) {
        if (!is_array($array)) {
            throw new InvalidArgumentException('Input must be an array.');
        }

        $n = count($array);
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                if ($array[$j] > $array[$j + 1]) {
                    // Swap elements if they are in wrong order
                    $temp = $array[$j];
                    $array[$j] = $array[$j + 1];
                    $array[$j + 1] = $temp;
                }
            }
        }

        return $array;
    }

    /**
     * Quick Sort algorithm implementation
     *
     * @param array $array The array to sort
     * @return array The sorted array
     */
    public function quickSort(array $array) {
        if (!is_array($array)) {
            throw new InvalidArgumentException('Input must be an array.');
        }

        if (count($array) < 2) {
            return $array;
        }

        $left = $right = [];
        $pivot = array_shift($array);

        foreach ($array as $value) {
            if ($value < $pivot) {
                $left[] = $value;
            } elseif ($value > $pivot) {
                $right[] = $value;
            }
        }

        return array_merge($this->quickSort($left), [$pivot], $this->quickSort($right));
    }

    /**
     * Insertion Sort algorithm implementation
     *
     * @param array $array The array to sort
     * @return array The sorted array
     */
    public function insertionSort(array $array) {
        if (!is_array($array)) {
            throw new InvalidArgumentException('Input must be an array.');
        }

        foreach ($array as $key => $value) {
            if ($key > 0 && $array[$key - 1] > $value) {
                $temp = $value;
                // Find the position where the element should be inserted
                for ($i = $key; $i > 0 && $array[$i - 1] > $temp; $i--) {
                    $array[$i] = $array[$i - 1];
                }
                $array[$i] = $temp;
            }
        }

        return $array;
    }
}

// Usage example
$sorter = new SortingAlgorithm();
$array = [5, 3, 8, 4, 2];

try {
    echo "Sorted array using bubble sort: ";
    print_r($sorter->bubbleSort($array));

    echo "Sorted array using quick sort: ";
    print_r($sorter->quickSort($array));

    echo "Sorted array using insertion sort: ";
    print_r($sorter->insertionSort($array));
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
