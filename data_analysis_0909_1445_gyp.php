<?php
// 代码生成时间: 2025-09-09 14:45:31
class DataAnalysis {

    private $data = [];

    /**
     * 构造函数
     *
     * 初始化数据
     *
     * @param array $data 要分析的数据
     */
    public function __construct(array $data) {
        $this->data = $data;
    }

    /**
     * 数据求和
     *
     * 对数据集中的数值进行求和
     *
     * @return float 数据集的和
     */
    public function sum() {
        $sum = 0;
        foreach ($this->data as $value) {
            if (is_numeric($value)) {
                $sum += $value;
            } else {
                // 错误处理：跳过非数值数据
                continue;
            }
        }
        return $sum;
    }

    /**
     * 数据平均值
     *
     * 计算数据集的平均值
     *
     * @return float 数据集的平均值
     */
    public function average() {
        $sum = $this->sum();
        $count = count($this->data);
        return $count > 0 ? $sum / $count : 0;
    }

    /**
     * 数据中位数
     *
     * 计算数据集的中位数
     *
     * @return float 数据集的中位数
     */
    public function median() {
        sort($this->data);
        $count = count($this->data);
        $middle = floor(($count - 1) / 2);
        if ($count % 2) {
            // 奇数个数据，返回中间值
            return $this->data[$middle];
        } else {
            // 偶数个数据，返回中间两个值的平均值
            return ($this->data[$middle] + $this->data[$middle + 1]) / 2;
        }
    }

    /**
     * 数据最大值
     *
     * 找出数据集中的最大值
     *
     * @return mixed 数据集中的最大值
     */
    public function max() {
        return max($this->data);
    }

    /**
     * 数据最小值
     *
     * 找出数据集中的最小值
     *
     * @return mixed 数据集中的最小值
     */
    public function min() {
        return min($this->data);
    }

    /**
     * 数据标准差
     *
     * 计算数据集的标准差
     *
     * @return float 数据集的标准差
     */
    public function standardDeviation() {
        $mean = $this->average();
        $deviations = array_map(function($value) use ($mean) {
            return pow($value - $mean, 2);
        }, $this->data);
        $variance = $this->average($deviations);
        return sqrt($variance);
    }

    /**
     * 数据方差
     *
     * 计算数据集的方差
     *
     * @return float 数据集的方差
     */
    public function variance() {
        $mean = $this->average();
        $deviations = array_map(function($value) use ($mean) {
            return pow($value - $mean, 2);
        }, $this->data);
        return $this->average($deviations);
    }
}

// 示例使用
$data = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
$analysis = new DataAnalysis($data);

echo "Sum: " . $analysis->sum() . "
";
echo "Average: " . $analysis->average() . "
";
echo "Median: " . $analysis->median() . "
";
echo "Max: " . $analysis->max() . "
";
echo "Min: " . $analysis->min() . "
";
echo "Standard Deviation: " . $analysis->standardDeviation() . "
";
echo "Variance: " . $analysis->variance() . "
";

?>