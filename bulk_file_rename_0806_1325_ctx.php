<?php
// 代码生成时间: 2025-08-06 13:25:17
// 引入Zend框架的文件系统组件
use Zend\Filter\Word\DashToCamelCase;
use Zend\Filter\StringToLower;
use Zend\Filter\StringToUpper;
use Zend\Filter\PregReplace;
use Zend\Filter\FilterChain;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use DirectoryIterator;

class BulkFileRenameTool
{
    protected $sourceDir;
    protected $newDir;
    protected $filterChain;

    /**
     * 构造函数
     *
     * @param string $sourceDir 源目录
     * @param string $newDir 新目录
     */
    public function __construct($sourceDir, $newDir)
    {
        $this->sourceDir = $sourceDir;
        $this->newDir = $newDir;

        // 创建一个过滤链
        $this->filterChain = new FilterChain();

        // 添加过滤器
        $this->filterChain->attach(new StringToLower())
                       ->attach(new DashToCamelCase())
                       ->attach(new StringToUpper());
    }

    /**
     * 添加重命名规则
     *
     * @param callable $callback 重命名规则
     */
    public function addRenameRule($callback)
    {
        $this->filterChain->attach(new PregReplace(['/pattern/', '/replacement/'], $callback));
    }

    /**
     * 执行批量文件重命名
     *
     * @return void
     */
    public function renameFiles()
    {
        // 检查源目录是否存在
        if (!is_dir($this->sourceDir)) {
            throw new Exception('Source directory does not exist.');
        }

        // 确保目标目录存在
        if (!is_dir($this->newDir)) {
            mkdir($this->newDir, 0777, true);
        }

        // 遍历源目录
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($this->sourceDir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            if ($item instanceof DirectoryIterator) {
                continue;
            }

            // 应用过滤链到文件名
            $newFileName = $this->sourceDir . DIRECTORY_SEPARATOR . $this->filterChain->filter($item->getFilename());
            $newPath = $this->newDir . DIRECTORY_SEPARATOR . $this->filterChain->filter($item->getFilename());

            // 重命名文件
            if (!rename($item->getPathname(), $newPath)) {
                throw new Exception('Failed to rename file: ' . $item->getFilename());
            }
        }
    }
}

// 使用示例
try {
    $renameTool = new BulkFileRenameTool('/path/to/source', '/path/to/new');
    // 添加自定义重命名规则
    $renameTool->addRenameRule(function($match) {
        return str_replace('old', 'new', $match[0]);
    });

    // 执行重命名
    $renameTool->renameFiles();
    echo 'Files have been renamed successfully.';
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
