<?php
// 代码生成时间: 2025-08-13 11:44:11
class ExcelGenerator {

    /**
     * PHPExcel对象
     *
     * @var PHPExcel
     */
    private $objPHPExcel;

    /**
     * 构造函数
     *
     * 初始化PHPExcel对象
     */
    public function __construct() {
        $this->objPHPExcel = new PHPExcel();
    }

    /**
     * 创建一个新的Excel工作表
     *
     * @param string $title 工作表标题
     * @return PHPExcel_Worksheet
     */
    public function createSheet($title) {
        $sheet = $this->objPHPExcel->createSheet();
        $sheet->setTitle($title);
        return $sheet;
    }

    /**
     * 在工作表中写入数据
     *
     * @param PHPExcel_Worksheet $sheet 工作表对象
     * @param array $data 数据数组
     * @param int $startRow 起始行号
     * @param int $startCol 起始列号
     * @return void
     */
    public function writeData(PHPExcel_Worksheet $sheet, array $data, $startRow = 1, $startCol = 'A') {
        foreach ($data as $rowIndex => $rowData) {
            foreach ($rowData as $colIndex => $value) {
                $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex) . ($rowIndex + $startRow), $value);
            }
        }
    }

    /**
     * 设置工作表的标题
     *
     * @param PHPExcel_Worksheet $sheet 工作表对象
     * @param string $title 标题内容
     * @return void
     */
    public function setTitle(PHPExcel_Worksheet $sheet, $title) {
        $sheet->setTitle($title);
    }

    /**
     * 设置单元格样式
     *
     * @param PHPExcel_Worksheet $sheet 工作表对象
     * @param mixed $cell 单元格或单元格范围
     * @param PHPExcel_Style $style 样式对象
     * @return void
     */
    public function setCellStyle(PHPExcel_Worksheet $sheet, $cell, PHPExcel_Style $style) {
        $sheet->getStyle($cell)->applyFromArray($style->getArray());
    }

    /**
     * 保存Excel文件
     *
     * @param string $filePath 文件路径
     * @return bool
     */
    public function save($filePath) {
        try {
            $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');
            $objWriter->save($filePath);
            return true;
        } catch (Exception $e) {
            // 错误处理
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
}

// 使用示例
try {
    $generator = new ExcelGenerator();
    $sheet = $generator->createSheet('示例工作表');
    $generator->setTitle($sheet, '示例工作表');
    $data = [
        [
            '姓名', '年龄', '性别',
        ],
        [
            '张三', 28, '男',
        ],
        [
            '李四', 25, '女',
        ],
    ];
    $generator->writeData($sheet, $data);
    $filePath = 'example.xlsx';
    $generator->save($filePath);
    echo 'Excel文件已生成：' . $filePath;
} catch (Exception $e) {
    // 错误处理
    echo 'Error: ' . $e->getMessage();
}
