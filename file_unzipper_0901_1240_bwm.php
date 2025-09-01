<?php
// 代码生成时间: 2025-09-01 12:40:54
class FileUnzipper {

    /**
     * 解压文件到指定目录
     *
     * @param string $file 要解压的文件路径
     * @param string $destination 解压到的目录路径
     *
     * @return boolean 返回解压是否成功
     */
    public function unzip($file, $destination) {
        // 检查文件是否存在
        if (!file_exists($file)) {
            // 抛出异常：文件不存在
            throw new Exception("File not found: {$file}");
        }

        // 检查目录是否存在，如果不存在则创建
        if (!is_dir($destination)) {
            if (!mkdir($destination, 0777, true)) {
                // 抛出异常：目录创建失败
                throw new Exception("Failed to create directory: {$destination}");
            }
        }

        // 初始化ZipArchive类
        $zip = new ZipArchive();

        // 打开Zip文件
        if ($zip->open($file) === TRUE) {
            // 将文件解压到指定目录
            $zip->extractTo($destination);
            $zip->close();
            return true;
        } else {
            // 抛出异常：无法打开Zip文件
            throw new Exception("Failed to open zip file: {$file}");
        }
    }
}

// 使用示例
try {
    $unzipper = new FileUnzipper();
    $file = 'path/to/your/file.zip';
    $destination = 'path/to/destination';
    if ($unzipper->unzip($file, $destination)) {
        echo "File has been successfully unzipped to {$destination}.";
    } else {
        echo "Failed to unzip file.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
