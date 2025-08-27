<?php
// 代码生成时间: 2025-08-27 10:36:34
class JsonConverter {

    /**
     * 转换JSON数据
     *
     * @param string $inputJson 原始JSON字符串
     * @param array $transformers 数据转换规则
     * @return string 转换后的JSON字符串
     * @throws InvalidArgumentException
     */
    public function transform($inputJson, array $transformers) {
        // 尝试解析JSON字符串
        $data = json_decode($inputJson, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException('Invalid JSON input.');
        }

        // 应用转换规则
        foreach ($transformers as $key => $callback) {
            if (isset($data[$key])) {
                $data[$key] = call_user_func($callback, $data[$key]);
            }
        }

        // 将数组编码回JSON字符串
        $outputJson = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        return $outputJson;
    }
}

// 示例用法
try {
    $converter = new JsonConverter();
    $inputJson = '{"name":"John Doe", "age":30}';
    $transformers = [
        'name' => function($name) {
            return ucwords($name);
        },
        'age' => function($age) {
            return $age * 365; // 转换年龄为天数
        }
    ];

    $outputJson = $converter->transform($inputJson, $transformers);
    echo $outputJson;
} catch (InvalidArgumentException $e) {
    echo "Error: " . $e->getMessage();
}
