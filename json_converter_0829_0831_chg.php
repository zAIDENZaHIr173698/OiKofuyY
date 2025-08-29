<?php
// 代码生成时间: 2025-08-29 08:31:53
// 引入ZEND框架的组件
use Zend\Json\Decoder;
use Zend\Json\Encoder;

class JsonConverter {

    private $decoder;
    private $encoder;

    /**
     * 构造函数，初始化解码器和编码器
     */
    public function __construct() {
        $this->decoder = new Decoder();
        $this->encoder = new Encoder();
    }

    /**
     * 将JSON字符串转换为PHP数组
     *
     * @param string $json JSON字符串
     * @return array PHP数组，转换成功返回数组，失败返回null
     */
    public function jsonToArray($json) {
        try {
            return $this->decoder->decode($json);
        } catch (Exception $e) {
            // 错误处理
            error_log($e->getMessage());
            return null;
        }
    }

    /**
     * 将PHP数组转换为JSON字符串
     *
     * @param array $array PHP数组
     * @return string JSON字符串，转换成功返回JSON字符串，失败返回null
     */
    public function arrayToJson($array) {
        try {
            return $this->encoder->encode($array);
        } catch (Exception $e) {
            // 错误处理
            error_log($e->getMessage());
            return null;
        }
    }

}

// 示例用法
$jsonConverter = new JsonConverter();

// 将JSON字符串转换为数组
$jsonString = "{"name":"John","age":30}";
$array = $jsonConverter->jsonToArray($jsonString);
if ($array !== null) {
    echo "Array: ";
    print_r($array);
} else {
    echo "Error converting JSON to array";
}

// 将数组转换为JSON字符串
$phpArray = array("name" => "John", "age" => 30);
$jsonString = $jsonConverter->arrayToJson($phpArray);
if ($jsonString !== null) {
    echo "JSON: " . $jsonString;
} else {
    echo "Error converting array to JSON";
}
