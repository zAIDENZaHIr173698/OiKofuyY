<?php
// 代码生成时间: 2025-09-19 19:55:18
// Define the path to the configuration directory
define('CONFIG_DIR', __DIR__ . '/config/');

class ConfigManager {

    // Load a configuration file
    public function loadConfig($filename) {
        // Check if the file exists
        if (!file_exists(CONFIG_DIR . $filename)) {
            // Throw an exception if the file does not exist
            throw new Exception("Configuration file not found: {$filename}");
        }

        // Return the loaded configuration data
        return include(CONFIG_DIR . $filename);
    }

    // Save a configuration file
    public function saveConfig($filename, $configData) {
        // Check if the directory exists and is writable
        if (!is_writable(CONFIG_DIR)) {
            // Throw an exception if the directory is not writable
            throw new Exception("Configuration directory is not writable");
        }

        // Write the configuration data to a file
        if (file_put_contents(CONFIG_DIR . $filename, var_export($configData, true)) === false) {
            // Throw an exception if the file cannot be written
            throw new Exception("Failed to write configuration file: {$filename}");
        }
    }
}

// Example usage
try {
    $configManager = new ConfigManager();
    
    // Load a configuration file
    $config = $configManager->loadConfig('settings.php');
    print_r($config);
    
    // Save a configuration file
    $configManager->saveConfig('new_settings.php', array('key' => 'value'));
    
} catch (Exception $e) {
    // Handle any exceptions that occur
    echo "Error: " . $e->getMessage();
}
