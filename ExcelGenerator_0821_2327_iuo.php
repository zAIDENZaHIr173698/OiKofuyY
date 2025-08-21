<?php
// 代码生成时间: 2025-08-21 23:27:32
class ExcelGenerator {

    private $objPHPExcel;
    private $activeSheet;

    /**
     * 构造函数
     * 初始化PHPExcel对象和活动工作表
     */
    public function __construct() {
        require_once 'PHPExcel/Classes/PHPExcel.php';
        $this->objPHPExcel = new PHPExcel();
        $this->activeSheet = $this->objPHPExcel->getActiveSheet();
    }

    /**
     * 设置工作表标题
     *
     * @param string $title 工作表标题
     */
    public function setTitle($title) {
        $this->activeSheet->setTitle($title);
    }

    /**
     * 添加标题行
     *
     * @param array $titles 标题数组
     */
    public function addHeaderRow($titles) {
        $rowNum = 1;
        foreach ($titles as $title) {
            $this->activeSheet->setCellValueByColumnAndRow($rowNum, 1, $title);
            ++$rowNum;
        }
    }

    /**
     * 添加数据行
     *
     * @param array $data 数据数组
     */
    public function addDataRow($data) {
        $rowNum = 2; // 从第二行开始添加数据
        foreach ($data as $value) {
            $this->activeSheet->setCellValueByColumnAndRow(1, $rowNum, $value);
            ++$rowNum;
        }
    }

    /**
     * 保存Excel文件
     *
     * @param string $filename 文件名
     *
     * @return bool 成功或失败
     */
    public function save($filename) {
        try {
            $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');
            $objWriter->save($filename);
            return true;
        } catch (Exception $e) {
            // 错误处理
            error_log('Excel生成失败: ' . $e->getMessage());
            return false;
        }
    }
}

// 使用示例
$excelGen = new ExcelGenerator();
$excelGen->setTitle('示例数据');
$excelGen->addHeaderRow(['姓名', '年龄', '城市']);
$excelGen->addDataRow(['张三', 28, '北京']);
$excelGen->addDataRow(['李四', 25, '上海']);
if ($excelGen->save('example.xlsx')) {
    echo 'Excel文件生成成功';
} else {
    echo 'Excel文件生成失败';
}
