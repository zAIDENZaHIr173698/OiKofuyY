<?php
// 代码生成时间: 2025-09-10 13:59:54
class ImageResizer {

    /**
     * @var string $sourcePath The path to the source directory containing images.
     */
    private $sourcePath;

    /**
     * @var string $destinationPath The path to the destination directory where resized images will be saved.
     */
    private $destinationPath;

    /**
     * @var int $targetWidth The target width for the resized images.
     */
    private $targetWidth;

    /**
     * @var int $targetHeight The target height for the resized images.
     */
    private $targetHeight;

    /**
     * Constructor for ImageResizer class.
     *
     * @param string $sourcePath The source directory path.
     * @param string $destinationPath The destination directory path.
     * @param int $targetWidth The target width for resizing.
     * @param int $targetHeight The target height for resizing.
     */
    public function __construct($sourcePath, $destinationPath, $targetWidth, $targetHeight) {
        $this->sourcePath = $sourcePath;
        $this->destinationPath = $destinationPath;
        $this->targetWidth = $targetWidth;
        $this->targetHeight = $targetHeight;
    }

    /**
     * Resizes all images in the source directory to the target dimensions and saves them to the destination directory.
     *
     * @return void
     */
    public function resizeAllImages() {
        if (!is_dir($this->sourcePath) || !is_dir($this->destinationPath)) {
            throw new Exception('Source or destination directory does not exist.');
        }

        $files = scandir($this->sourcePath);
        foreach ($files as $file) {
            if (in_array($file, ['.', '..'])) continue;

            $sourceFile = $this->sourcePath . '/' . $file;
            $destinationFile = $this->destinationPath . '/' . $file;

            $this->resizeImage($sourceFile, $destinationFile);
        }
    }

    /**
     * Resizes a single image to the target dimensions.
     *
     * @param string $sourceFile The path to the image to be resized.
     * @param string $destinationFile The path where the resized image will be saved.
     * @return void
     */
    private function resizeImage($sourceFile, $destinationFile) {
        $image = new Imagick($sourceFile);
        $image->resizeImage($this->targetWidth, $this->targetHeight, Imagick::FILTER_LANCZOS, 1);
        $image->writeImage($destinationFile);
        $image->clear();
        $image->destroy();
    }
}

// Usage example:
try {
    $imageResizer = new ImageResizer('/path/to/source', '/path/to/destination', 800, 600);
    $imageResizer->resizeAllImages();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
