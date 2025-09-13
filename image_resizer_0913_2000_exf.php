<?php
// 代码生成时间: 2025-09-13 20:00:38
class ImageResizer 
{
    private $sourceDir;
    private $destinationDir;
    private $maxWidth;
    private $maxHeight;
    private $quality;

    /**
     * 构造函数
     *
     * @param string $sourceDir 源图片目录
     * @param string $destinationDir 目标图片目录
     * @param int $maxWidth 最大宽度
     * @param int $maxHeight 最大高度
     * @param int $quality 图片质量
     */
    public function __construct($sourceDir, $destinationDir, $maxWidth, $maxHeight, $quality = 90) 
    {
        $this->sourceDir = $sourceDir;
        $this->destinationDir = $destinationDir;
        $this->maxWidth = $maxWidth;
        $this->maxHeight = $maxHeight;
        $this->quality = $quality;
    }

    /**
     * 调整图片尺寸
     *
     * @return bool 返回调整结果
     */
    public function resizeImages() 
    {
        if (!is_dir($this->sourceDir) || !is_dir($this->destinationDir)) {
            throw new Exception('源目录或目标目录不存在');
        }

        $files = scandir($this->sourceDir);
        foreach ($files as $file) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }
            $sourcePath = $this->sourceDir . '/' . $file;
            $destinationPath = $this->destinationDir . '/' . $file;
            if (!$this->resizeImage($sourcePath, $destinationPath)) {
                throw new Exception('调整图片尺寸失败');
            }
        }
        return true;
    }

    /**
     * 单个图片尺寸调整
     *
     * @param string $sourcePath 源图片路径
     * @param string $destinationPath 目标图片路径
     * @return bool 返回调整结果
     */
    private function resizeImage($sourcePath, $destinationPath) 
    {
        $imageInfo = getimagesize($sourcePath);
        $width = $imageInfo[0];
        $height = $imageInfo[1];

        if ($width > $this->maxWidth || $height > $this->maxHeight) {
            if ($width > $height) {
                $ratio = $this->maxWidth / $width;
            } else {
                $ratio = $this->maxHeight / $height;
            }
            $newWidth = $width * $ratio;
            $newHeight = $height * $ratio;

            switch ($imageInfo[2]) {
                case IMAGETYPE_JPEG:
                    $image = imagecreatefromjpeg($sourcePath);
                    $newImage = imagecreatetruecolor($newWidth, $newHeight);
                    break;
                case IMAGETYPE_PNG:
                    $image = imagecreatefrompng($sourcePath);
                    $newImage = imagecreatetruecolor($newWidth, $newHeight);
                    imagealphablending($newImage, false);
                    imagesavealpha($newImage, true);
                    break;
                case IMAGETYPE_GIF:
                    $image = imagecreatefromgif($sourcePath);
                    $newImage = imagecreatetruecolor($newWidth, $newHeight);
                    imagealphablending($newImage, false);
                    imagesavealpha($newImage, true);
                    break;
                default:
                    return false;
            }

            imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            if ($imageInfo[2] == IMAGETYPE_JPEG) {
                imagejpeg($newImage, $destinationPath, $this->quality);
            } elseif ($imageInfo[2] == IMAGETYPE_PNG) {
                imagepng($newImage, $destinationPath);
            } elseif ($imageInfo[2] == IMAGETYPE_GIF) {
                imagegif($newImage, $destinationPath);
            }

            imagedestroy($image);
            imagedestroy($newImage);
            return true;
        } else {
            return copy($sourcePath, $destinationPath);
        }
    }
}

// 使用示例
try {
    $resizer = new ImageResizer('/path/to/source', '/path/to/destination', 800, 600);
    $resizer->resizeImages();
    echo '图片尺寸调整成功';
} catch (Exception $e) {
    echo '错误: ' . $e->getMessage();
}
