<?php
// 代码生成时间: 2025-08-25 05:08:26
class ImageResizer {

    /**
     * @var array $errors Stores any errors encountered during processing.
     */
    private $errors = [];

    /**
     * Resizes an image to a specified width and height.
     *
     * @param string $sourcePath The path to the source image.
     * @param string $destinationPath The path to save the resized image.
     * @param int $width The desired width of the resized image.
     * @param int $height The desired height of the resized image.
     * @param bool $maintainRatio Whether to maintain the aspect ratio of the original image.
     * @return bool Returns true on success, false on failure.
     */
    public function resizeImage($sourcePath, $destinationPath, $width, $height, $maintainRatio = true) {
        // Check if the file exists
        if (!file_exists($sourcePath)) {
            $this->errors[] = 'File not found: ' . $sourcePath;
            return false;
        }

        // Get image dimensions
        list($srcWidth, $srcHeight) = getimagesize($sourcePath);

        // Calculate new dimensions while maintaining the aspect ratio if required
        if ($maintainRatio) {
            $ratio = $srcWidth / $srcHeight;
            if ($width / $height > $ratio) {
                $width = $height * $ratio;
            } else {
                $height = $width / $ratio;
            }
        }

        // Create a new image from the source
        $image = $this->createImageFromFile($sourcePath);
        if (!$image) {
            $this->errors[] = 'Failed to create image from file: ' . $sourcePath;
            return false;
        }

        // Create a new true color image with alpha transparency
        $resizedImage = imagecreatetruecolor($width, $height);

        // Copy and resize the old image into the new image
        imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);

        // Save the resized image
        if (!$this->saveImage($resizedImage, $destinationPath)) {
            $this->errors[] = 'Failed to save resized image to: ' . $destinationPath;
            return false;
        }

        // Free up memory
        imagedestroy($resizedImage);
        imagedestroy($image);

        return true;
    }

    /**
     * Creates a GD image resource from a file.
     *
     * @param string $filePath The path to the image file.
     * @return resource|false Returns the GD image resource on success, false on failure.
     */
    private function createImageFromFile($filePath) {
        $imageInfo = getimagesize($filePath);
        $imageType = $imageInfo[2];

        if (!$imageType) {
            return false;
        }

        switch ($imageType) {
            case IMAGETYPE_JPEG:
                return imagecreatefromjpeg($filePath);
            case IMAGETYPE_GIF:
                return imagecreatefromgif($filePath);
            case IMAGETYPE_PNG:
                return imagecreatefrompng($filePath);
            default:
                return false;
        }
    }

    /**
     * Saves a GD image resource to a file.
     *
     * @param resource $image The GD image resource to save.
     * @param string $destinationPath The path to save the image.
     * @return bool Returns true on success, false on failure.
     */
    private function saveImage($image, $destinationPath) {
        $imageInfo = getimagesize($destinationPath);
        $imageType = $imageInfo[2];

        if (!$imageType) {
            return false;
        }

        switch ($imageType) {
            case IMAGETYPE_JPEG:
                return imagejpeg($image, $destinationPath, 100);
            case IMAGETYPE_GIF:
                return imagegif($image, $destinationPath);
            case IMAGETYPE_PNG:
                return imagepng($image, $destinationPath);
            default:
                return false;
        }
    }

    /**
     * Retrieves any errors encountered during image processing.
     *
     * @return array Returns an array of error messages.
     */
    public function getErrors() {
        return $this->errors;
    }
}

// Example usage:
$resizer = new ImageResizer();
$resizer->resizeImage('path/to/source/image.jpg', 'path/to/destination/image.jpg', 100, 100);
$errors = $resizer->getErrors();
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "
";
    }
} else {
    echo 'Images resized successfully.';
}