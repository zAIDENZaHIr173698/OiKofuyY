<?php
// 代码生成时间: 2025-09-13 08:38:47
class FolderOrganizer {

    private $sourceDir;
    private $destinationDir;
    private $fileMap = [];

    /**
     * Constructor
     * @param string $sourceDir The source directory to organize files from.
     * @param string $destinationDir The destination directory to organize files to.
     */
    public function __construct($sourceDir, $destinationDir) {
        $this->sourceDir = $sourceDir;
        $this->destinationDir = $destinationDir;
    }

    /**
     * Organize the files in the source directory.
     * @return void
     */
    public function organize() {
        try {
            // Check if the source directory exists
            if (!is_dir($this->sourceDir)) {
                throw new Exception('Source directory does not exist.');
            }

            // Create the destination directory if it doesn't exist
            if (!is_dir($this->destinationDir)) {
                mkdir($this->destinationDir, 0777, true);
            }

            // Scan the source directory for files and folders
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($this->sourceDir),
                RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($iterator as $item) {
                /** @var SplFileInfo $item */
                if ($item->isFile()) {
                    $this->moveFile($item);
                }
            }

        } catch (Exception $e) {
            // Handle any exceptions that occur during the organization process
            error_log($e->getMessage());
        }
    }

    /**
     * Move a file to the appropriate directory based on its extension.
     * @param SplFileInfo $file The file to move.
     * @return void
     */
    private function moveFile(SplFileInfo $file) {
        $extension = $file->getExtension();
        $destinationPath = $this->destinationDir . DIRECTORY_SEPARATOR . $extension;

        // Create the extension directory if it doesn't exist
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Move the file to the new directory
        if (!rename($file->getRealPath(), $destinationPath . DIRECTORY_SEPARATOR . $file->getFilename())) {
            throw new Exception('Failed to move file: ' . $file->getFilename());
        }
    }
}

// Example usage:
// $organizer = new FolderOrganizer('/path/to/source', '/path/to/destination');
// $organizer->organize();
