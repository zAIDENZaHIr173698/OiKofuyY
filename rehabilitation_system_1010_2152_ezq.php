<?php
// 代码生成时间: 2025-10-10 21:52:59
require 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();

class RehabilitationSystem {

    /**
     * @var array $exercises
     * Stores the list of exercises.
     */
    private $exercises = [];

    /**
     * Constructor
     * Initializes the rehabilitation system with exercises.
     *
     * @param array $exercises
     */
    public function __construct(array $exercises) {
        $this->exercises = $exercises;
    }

    /**
     * Add an exercise to the rehabilitation system.
     *
     * @param string $name
     * @param string $description
     * @return bool
     */
    public function addExercise($name, $description) {
        try {
            if (empty($name) || empty($description)) {
                throw new Exception('Exercise name and description cannot be empty.');
            }
            $this->exercises[$name] = $description;
            return true;
        } catch (Exception $e) {
            // Log the error and return false
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Get an exercise by name.
     *
     * @param string $name
     * @return string|null
     */
    public function getExercise($name) {
        if (array_key_exists($name, $this->exercises)) {
            return $this->exercises[$name];
        }
        return null;
    }

    /**
     * Update an existing exercise.
     *
     * @param string $name
     * @param string $newDescription
     * @return bool
     */
    public function updateExercise($name, $newDescription) {
        try {
            if (empty($newDescription)) {
                throw new Exception('New description cannot be empty.');
            }
            if (!array_key_exists($name, $this->exercises)) {
                throw new Exception('Exercise not found.');
            }
            $this->exercises[$name] = $newDescription;
            return true;
        } catch (Exception $e) {
            // Log the error and return false
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Remove an exercise from the system.
     *
     * @param string $name
     * @return bool
     */
    public function removeExercise($name) {
        if (array_key_exists($name, $this->exercises)) {
            unset($this->exercises[$name]);
            return true;
        }
        return false;
    }

    /**
     * Get all exercises in the system.
     *
     * @return array
     */
    public function getAllExercises() {
        return $this->exercises;
    }
}

// Usage example
try {
    $rehabSystem = new RehabilitationSystem([
        'stretching' => 'Perform gentle stretches for flexibility.',
        'strengthening' => 'Complete resistance exercises to build strength.'
    ]);

    // Add a new exercise
    $rehabSystem->addExercise('balance_training', 'Practice balance exercises to improve stability.');

    // Get an exercise
    $exercise = $rehabSystem->getExercise('balance_training');
    echo "Exercise: $exercise
";

    // Update an exercise
    $rehabSystem->updateExercise('balance_training', 'Practice advanced balance exercises to improve stability.');

    // Remove an exercise
    $rehabSystem->removeExercise('stretching');

    // Get all exercises
    $allExercises = $rehabSystem->getAllExercises();
    print_r($allExercises);
} catch (Exception $e) {
    // Handle any exceptions that may occur
    error_log($e->getMessage());
}
