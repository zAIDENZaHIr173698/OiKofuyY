<?php
// 代码生成时间: 2025-09-09 02:36:39
 * It recursively sorts files into subdirectories based on file extensions.
 */
class FolderOrganizer {

    private $sourceDir;
    private $destinationDir;

    /**
     * Constructor
     * @param string $sourceDir The directory to organize files from
     * @param string $destinationDir The directory to organize files into
     */
    public function __construct($sourceDir, $destinationDir) {
        $this->sourceDir = $sourceDir;
        $this->destinationDir = $destinationDir;
    }

    /**
     * Organize files in the source directory
     */
    public function organize() {
        if (!is_dir($this->sourceDir)) {
            throw new Exception("Source directory does not exist: " . $this->sourceDir);
        }

        if (!is_dir($this->destinationDir)) {
            if (!mkdir($this->destinationDir, 0777, true)) {
                throw new Exception("Failed to create destination directory: " . $this->destinationDir);
            }
        }

        $this->sortFiles($this->sourceDir, $this->destinationDir);
    }

    /**
     * Recursively sort files into subdirectories based on file extensions
     * @param string $dir The directory to scan
     * @param string $destDir The destination directory
     */
    private function sortFiles($dir, $destDir) {
        $files = new DirectoryIterator($dir);
        foreach ($files as $file) {
            if ($file->isDot() || $file->isDir()) {
                continue;
            }

            $extension = pathinfo($file->getFilename(), PATHINFO_EXTENSION);
            $newDir = $destDir . '/' . $extension;

            if (!is_dir($newDir)) {
                mkdir($newDir, 0777, true);
            }

            $sourceFile = $file->getPathname();
            $destFile = $newDir . '/' . $file->getFilename();

            if (!rename($sourceFile, $destFile)) {
                throw new Exception("Failed to move file: " . $sourceFile);
            }
        }
    }
}

// Usage example
try {
    $sourceDirectory = "/path/to/source";
    $destinationDirectory = "/path/to/destination";

    $organizer = new FolderOrganizer($sourceDirectory, $destinationDirectory);
    $organizer->organize();
    echo "Files have been organized successfully.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
