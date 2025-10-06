<?php
// 代码生成时间: 2025-10-07 04:00:24
class ExcelGenerator {

    private $objPHPExcel;
    private $activeSheet;

    /**
     * Constructor to initialize the Excel object and active sheet
     */
    public function __construct() {
        try {
            $this->objPHPExcel = new Zend_Excel();
            $this->activeSheet = $this->objPHPExcel->getActiveSheet();
        } catch (Exception $e) {
            // Handle exceptions during object creation
            die('Error creating Excel object: ' . $e->getMessage());
        }
    }

    /**
     * Set the active sheet by index
     *
     * @param int $index The index of the sheet to activate
     */
    public function setActiveSheet($index) {
        $this->activeSheet = $this->objPHPExcel->getSheet($index);
    }

    /**
     * Add a row to the active sheet
     *
     * @param array $rowData Data to be added as a row
     */
    public function addRow($rowData) {
        foreach ($rowData as $cellIndex => $value) {
            $this->activeSheet->setCellValueByColumnAndRow($cellIndex + 1, $this->activeSheet->getCurrentRow() + 1, $value);
        }
    }

    /**
     * Set a value in a specific cell
     *
     * @param int $column Column index (1-based)
     * @param int $row Row index (1-based)
     * @param mixed $value Value to set
     */
    public function setCellValue($column, $row, $value) {
        $this->activeSheet->setCellValueByColumnAndRow($column, $row, $value);
    }

    /**
     * Save the Excel file to a specified path
     *
     * @param string $filePath Path to save the Excel file
     */
    public function save($filePath) {
        try {
            $writer = new Zend_Excel_Writer_Excel2007($this->objPHPExcel);
            $writer->save($filePath);
        } catch (Exception $e) {
            // Handle exceptions during saving
            die('Error saving Excel file: ' . $e->getMessage());
        }
    }

}

// Example usage:
try {
    $excelGenerator = new ExcelGenerator();
    $excelGenerator->addRow(array('Name', 'Age', 'City')); // Header row
    $excelGenerator->addRow(array('John Doe', 30, 'New York'));
    $excelGenerator->addRow(array('Jane Doe', 25, 'Los Angeles'));
    $excelGenerator->save('example.xlsx');
} catch (Exception $e) {
    // Handle any exceptions
    die('Error: ' . $e->getMessage());
}
