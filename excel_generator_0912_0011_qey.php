<?php
// 代码生成时间: 2025-09-12 00:11:23
require 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance()->registerNamespace('Zend_');

class ExcelGenerator {

    /**
     * 创建一个Excel文件
     *
     * @param array $data 要写入的数据
     * @param string $filename Excel文件名
     * @return void
     */
    public function createExcel($data, $filename) {
        try {
            $writer = new Zend_Excel_Writer_Excel2007($filename); // 创建Excel2007写入器
            $worksheet = $writer->addWorksheet('Sheet1'); // 添加一个工作表
            $row = 1;
            foreach ($data as $key => $value) {
                $worksheet->writeRow($row, 0, array_keys($value)); // 写入表头
                $row++;
                foreach ($value as $rowValue) {
                    $worksheet->writeRow($row, 0, $rowValue); // 写入数据
                    $row++;
                }
            }
            $writer->save(); // 保存文件
        } catch (Exception $e) {
            // 错误处理
            error_log($e->getMessage());
            throw new Exception('无法创建Excel文件: ' . $e->getMessage());
        }
    }

    /**
     * 获取示例数据
     *
     * @return array 示例数据
     */
    public function getSampleData() {
        return array(
            'Sheet1' => array(
                array(
                    'Name', 'Age', 'Email'
                ),
                array(
                    'John Doe', 30, 'john@example.com'
                ),
                array(
                    'Jane Doe', 25, 'jane@example.com'
                )
            )
        );
    }
}

// 示例用法
$excelGenerator = new ExcelGenerator();
$data = $excelGenerator->getSampleData();
$filename = 'example.xlsx';
$excelGenerator->createExcel($data, $filename);
