<?php
// 代码生成时间: 2025-09-18 19:53:44
// Include the Zend Framework's Bootstrap file
require_once 'path/to/Zend/Bootstrap.php';

// Initialize the Zend_Application
$application = new Zend_Application(
    APPLICATION_ENV,
    'path/to/application/configs/application.ini'
);

// Run the application
$application->bootstrap();

// Retrieve the front controller
$frontController = Zend_Controller_Front::getInstance();

// Check if the theme parameter is passed
if (isset($_GET['theme'])) {
    $theme = $_GET['theme'];

    // Validate the theme
    $validThemes = ['light', 'dark', 'colorful'];
    if (in_array($theme, $validThemes)) {
        // Set the theme in the session
        $session = new Zend_Session_Namespace('theme');
        $session->theme = $theme;

        // Redirect to the previous page or home page
        if (isset($_SERVER['HTTP_REFERER'])) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            header('Location: /');
        }
        exit;
    } else {
        // Handle invalid theme error
        echo 'Invalid theme selected.';
        exit;
    }
}

// Render the view
$frontController->dispatch();
?>