<?php
// 代码生成时间: 2025-08-12 07:31:31
class DataAnalysis {

    /**
     * 数据数组
     * @var array
     */
    private $data;

    /**
     * 构造函数
     *
     * @param array $data 要分析的数据
     */
    public function __construct(array $data) {
        $this->data = $data;
    }

    /**
     * 计算平均值
     *
     * @return float
     */
    public function calculateMean() {
        if (empty($this->data)) {
            throw new InvalidArgumentException('数据数组不能为空');
        }

        $sum = array_sum($this->data);
        $count = count($this->data);
        return $sum / $count;
    }

    /**
     * 计算中位数
     *
     * @return float
     */
    public function calculateMedian() {
        if (empty($this->data)) {
            throw new InvalidArgumentException('数据数组不能为空');
        }

        sort($this->data);
        $count = count($this->data);
        $middleIndex = floor(($count - 1) / 2);

        if ($count % 2) {
            return $this->data[$middleIndex];
        } else {
            return ($this->data[$middleIndex] + $this->data[$middleIndex + 1]) / 2;
        }
    }

    /**
     * 计算众数（最频繁出现的值）
     *
     * @return mixed
     */
    public function calculateMode() {
        if (empty($this->data)) {
            throw new InvalidArgumentException('数据数组不能为空');
        }

        $frequency = array_count_values($this->data);
        arsort($frequency);
        return array_key_first($frequency);
    }

    /**
     * 计算标准差
     *
     * @return float
     */
    public function calculateStandardDeviation() {
        if (empty($this->data)) {
            throw new InvalidArgumentException('数据数组不能为空');
        }

        $mean = $this->calculateMean();
        $deviations = array_map(function($value) use ($mean) {
            return pow($value - $mean, 2);
        }, $this->data);

        $variance = array_sum($deviations) / count($this->data);
        return sqrt($variance);
    }
}

// 使用示例
try {
    $data = [10, 20, 30, 40, 50];
    $analysis = new DataAnalysis($data);
    echo '平均值: ' . $analysis->calculateMean() . "
";
    echo '中位数: ' . $analysis->calculateMedian() . "
";
    echo '众数: ' . $analysis->calculateMode() . "
";
    echo '标准差: ' . $analysis->calculateStandardDeviation() . "
";
} catch (Exception $e) {
    echo '发生错误: ' . $e->getMessage();
}
