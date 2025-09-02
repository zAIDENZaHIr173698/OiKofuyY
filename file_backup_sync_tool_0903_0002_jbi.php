<?php
// 代码生成时间: 2025-09-03 00:02:19
class FileBackupSyncTool
{

    protected $sourceDir;
    protected $targetDir;
    protected $ignoreList = array();
    protected $logFile;

    /**
     * Constructor
     *
     * @param string $sourceDir Source directory path
     * @param string $targetDir Target directory path
     * @param string $logFile Log file path
     */
    public function __construct($sourceDir, $targetDir, $logFile)
    {
        $this->sourceDir = $sourceDir;
        $this->targetDir = $targetDir;
        $this->logFile = $logFile;
    }

    /**
     * Backup and sync files
     *
     * @return bool
     */
    public function backupAndSync()
    {
        try {
            if (!file_exists($this->sourceDir) || !file_exists($this->targetDir)) {
                throw new Exception("Source or target directory does not exist.");
            }

            $this->log("Backup and sync process started.");

            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($this->sourceDir),
                RecursiveIteratorIterator::SELF_FIRST
            );

            foreach ($iterator as $item) {
                if ($this->shouldIgnore($item)) {
                    continue;
                }

                $relativePath = $this->getRelativePath($item, $this->sourceDir);
                $targetPath = $this->targetDir . DIRECTORY_SEPARATOR . $relativePath;

                if ($item->isDir()) {
                    if (!file_exists($targetPath)) {
                        mkdir($targetPath, 0777, true);
                        $this->log("Created directory: {$targetPath}");
                    }
                } else {
                    if (!file_exists($targetPath)) {
                        copy($item->getPathname(), $targetPath);
                        $this->log("Copied file: {$targetPath}");
                    } elseif (filemtime($item->getPathname()) > filemtime($targetPath)) {
                        copy($item->getPathname(), $targetPath);
                        $this->log("Updated file: {$targetPath}");
                    }
                }
            }

            $this->log("Backup and sync process completed successfully.");

            return true;
        } catch (Exception $e) {
            $this->log("Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Add a file or directory to ignore
     *
     * @param string $path
     */
    public function addIgnore($path)
    {
        $this->ignoreList[] = $path;
    }

    /**
     * Check if a file or directory should be ignored
     *
     * @param RecursiveDirectoryIterator $item
     * @return bool
     */
    protected function shouldIgnore($item)
    {
        foreach ($this->ignoreList as $ignorePath) {
            if (strpos($item->getPathname(), $ignorePath) === 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get relative path from source directory
     *
     * @param RecursiveDirectoryIterator $item
     * @param string $sourceDir
     * @return string
     */
    protected function getRelativePath($item, $sourceDir)
    {
        return ltrim(str_replace($sourceDir, '', $item->getPathname()), DIRECTORY_SEPARATOR);
    }

    /**
     * Write a log message
     *
     * @param string $message
     */
    protected function log($message)
    {
        file_put_contents($this->logFile, $message . "
", FILE_APPEND);
    }

}

// Usage example
$sourceDir = "/path/to/source";
$targetDir = "/path/to/target";
$logFile = "/path/to/logfile.log";

$tool = new FileBackupSyncTool($sourceDir, $targetDir, $logFile);
$tool->addIgnore(".svn"); // Ignore SVN directories
$tool->backupAndSync();

?>