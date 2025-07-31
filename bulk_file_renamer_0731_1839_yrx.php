<?php
// 代码生成时间: 2025-07-31 18:39:07
require 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance()->registerNamespaceAutoload('YourApplication_', 'YourApplication/');

class BulkFileRenamer {

    /**
     * 重命名目录中的所有文件
     *
     * @param string $directory 需要重命名文件的目录
     * @param string $newPrefix 新文件名的前缀
     * @return void
     */
    public function renameFiles($directory, $newPrefix) {
        // 检查目录是否存在
        if (!is_dir($directory)) {
            throw new Exception("Directory does not exist: {$directory}");
        }

        // 获取目录中的所有文件
        $files = scandir($directory);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                // 构造新文件名并检查是否已存在
                $newName = $newPrefix . '_' . $file;
                if (file_exists($newName)) {
                    throw new Exception("File already exists: {$newName}");
                }

                // 重命名文件
                if (!rename($file, $newName)) {
                    throw new Exception("Failed to rename file: {$file} to {$newName}");
                }
            }
        }
    }
}

// 命令行界面
if (php_sapi_name() === 'cli') {
    // 检查参数数量
    if ($argc !== 3) {
        echo "Usage: php bulk_file_renamer.php <directory> <new_prefix>
";
        exit(1);
    }

    $directory = $argv[1];
    $newPrefix = $argv[2];

    try {
        $renamer = new BulkFileRenamer();
        $renamer->renameFiles($directory, $newPrefix);
        echo "Files renamed successfully.
";
    } catch (Exception $e) {
        echo "Error: {$e->getMessage()}
";
        exit(1);
    }
}
