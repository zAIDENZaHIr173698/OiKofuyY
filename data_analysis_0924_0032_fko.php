<?php
// 代码生成时间: 2025-09-24 00:32:35
class DataAnalysis {

    /**
     * @var array 存储数据
     */
    private $data;

    public function __construct(array $data) {
        // 初始化数据
        $this->data = $data;
    }

    /**
     * 计算平均值
     *
     * @return float
     */
    public function calculateAverage() {
        if (empty($this->data)) {
            throw new InvalidArgumentException('数据不能为空');
        }

        $sum = array_sum($this->data);
        $average = $sum / count($this->data);

        return $average;
    }

    /**
     * 计算中位数
     *
     * @return float
     */
    public function calculateMedian() {
        if (empty($this->data)) {
            throw new InvalidArgumentException('数据不能为空');
        }

        sort($this->data);
        $mid = count($this->data) / 2;
        $median = ($mid % 2) ? $this->data[floor($mid)] : ($this->data[floor($mid)] + $this->data[ceil($mid)]) / 2;

        return $median;
    }

    /**
     * 计算最大值
     *
     * @return mixed
     */
    public function calculateMax() {
        if (empty($this->data)) {
            throw new InvalidArgumentException('数据不能为空');
        }

        return max($this->data);
    }

    /**
     * 计算最小值
     *
     * @return mixed
     */
    public function calculateMin() {
        if (empty($this->data)) {
            throw new InvalidArgumentException('数据不能为空');
        }

        return min($this->data);
    }

}

// 示例用法
try {
    $data = [1, 2, 3, 4, 5];
    $analysis = new DataAnalysis($data);

    echo '平均值: ' . $analysis->calculateAverage() . "
";
    echo '中位数: ' . $analysis->calculateMedian() . "
";
    echo '最大值: ' . $analysis->calculateMax() . "
";
    echo '最小值: ' . $analysis->calculateMin() . "
";
} catch (Exception $e) {
    echo '错误: ' . $e->getMessage();
}
