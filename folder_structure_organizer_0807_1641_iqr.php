<?php
// 代码生成时间: 2025-08-07 16:41:50
class FolderStructureOrganizer {

    /**
     * The directory path to organize.
     *
     * @var string
     */
    private $directoryPath;

    /**
     * Constructor for the FolderStructureOrganizer class.
     *
     * @param string $directoryPath The directory path to organize.
     */
    public function __construct($directoryPath) {
        $this->directoryPath = $directoryPath;
    }

    /**
     * Organize the folder structure.
     *
     * @return void
     */
    public function organize() {
        try {
            // Check if the directory exists
            if (!file_exists($this->directoryPath) || !is_dir($this->directoryPath)) {
                throw new Exception('The specified directory does not exist.');
            }

            // Get all files and folders in the directory
            $filesAndFolders = scandir($this->directoryPath);

            // Remove '.' and '..' from the list
            $filesAndFolders = array_diff($filesAndFolders, array('.', '..'));

            foreach ($filesAndFolders as $item) {
                $fullPath = $this->directoryPath . '/' . $item;

                // Check if it's a file or a folder
                if (is_dir($fullPath)) {
                    // If it's a folder, create a new instance of FolderStructureOrganizer and organize it
                    $organizer = new FolderStructureOrganizer($fullPath);
                    $organizer->organize();
                } elseif (is_file($fullPath)) {
                    // If it's a file, categorize it based on its extension
                    $this->categorizeFile($fullPath);
                }
            }
        } catch (Exception $e) {
            // Handle any exceptions that occur during the organization process
            error_log($e->getMessage());
        }
    }

    /**
     * Categorize a file based on its extension.
     *
     * @param string $filePath The path to the file to categorize.
     *
     * @return void
     */
    private function categorizeFile($filePath) {
        // Get the file extension
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

        // Create a folder for the extension if it doesn't exist
        $folderPath = $this->directoryPath . '/' . $extension;
        if (!is_dir($folderPath)) {
            mkdir($folderPath);
        }

        // Move the file to the new folder
        rename($filePath, $folderPath . '/' . basename($filePath));
    }
}

// Example usage:
// $organizer = new FolderStructureOrganizer('/path/to/your/directory');
// $organizer->organize();