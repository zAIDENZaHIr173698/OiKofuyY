<?php
// 代码生成时间: 2025-09-19 15:53:53
require_once 'Zend/Excel.php';

class ExcelGenerator {

    private $objPHPExcel;

    /**
     * 构造函数
     * 初始化PHPExcel对象
     */
    public function __construct() {
        try {
            $this->objPHPExcel = new Zend_Excel();
        } catch (Exception $e) {
            // 错误处理
            die('Error initializing PHPExcel: ' . $e->getMessage());
        }
    }

    /**
     * 添加工作表
     *
     * @param string $sheetName 工作表名称
     */
    public function addWorksheet($sheetName) {
        $this->objPHPExcel->createSheet($sheetName);
        $this->objPHPExcel->setActiveSheetIndex(\$this->objPHPExcel->getIndex($sheetName));
    }

    /**
     * 写入数据到工作表
     *
     * @param array $data 要写入的数据
     * @param int $row 起始行号
     * @param int $column 起始列号
     */
    public function writeData($data, $row = 1, $column = 'A') {
        foreach ($data as $key => $value) {
            $this->objPHPExcel->getActiveSheet()->setCellValue(\$column . \$row, \$value);
            \$column = \$this->incrementColumnLetter(\$column);
        }
        \$row++;
    }

    /**
     * 列字母递增
     *
     * @param string $columnLetter 列字母
     * @return string 下一个列字母
     */
    private function incrementColumnLetter(\$columnLetter) {
        \$columnNumber = \$this->convertColumnLetterToNumber(\$columnLetter);
        return \$this->convertNumberToColumnLetter(\$columnNumber + 1);
    }

    /**
     * 列字母转数字
     *
     * @param string \$columnLetter 列字母
     * @return int 列数字
     */
    private function convertColumnLetterToNumber(\$columnLetter) {
        \$columnNumber = 0;
        \$letterArray = str_split(\$columnLetter);
        foreach (\$letterArray as \$letter) {
            \$columnNumber = (26 * \$columnNumber) + (\$letter - 64);
        }
        return \$columnNumber;
    }

    /**
     * 数字转列字母
     *
     * @param int \$columnNumber 列数字
     * @return string 列字母
     */
    private function convertNumberToColumnLetter(\$columnNumber) {
        \$columnLetter = '';
        do {
            \$modulo = \$columnNumber % 26;
            \$columnLetter = chr(65 + \$modulo) . \$columnLetter;
            \$columnNumber = (int)(\$columnNumber / 26) - 1;
        } while (\$columnNumber >= 0);
        return \$columnLetter;
    }

    /**
     * 保存Excel文件
     *
     * @param string $filename 要保存的文件名
     */
    public function save(\$filename) {
        try {
            \$this->objPHPExcel->save(\$filename . '.xlsx');
        } catch (Exception \$e) {
            // 错误处理
            die('Error saving Excel file: ' . \$e->getMessage());
        }
    }
}

// 使用示例
try {
    \$excel = new ExcelGenerator();
    \$excel->addWorksheet('Sheet1');
    \$data = array('Name', 'Age', 'City');
    \$excel->writeData(\$data);
    \$excel->save('example_excel_file');
} catch (Exception \$e) {
    // 错误处理
    die('Error: ' . \$e->getMessage());
}
