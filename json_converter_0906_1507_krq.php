<?php
// 代码生成时间: 2025-09-06 15:07:23
class JsonConverter {

    /**
     * 将JSON数据转换为PHP数组。
     *
     * @param string $json JSON字符串
     * @return array|false 转换后的数组，或在失败时返回false
     */
    public function decodeJsonToArray($json) {
        try {
            // 使用JSON decode函数将JSON字符串转换为数组
            $data = json_decode($json, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                // 如果解码失败，抛出异常
                throw new Exception('JSON decode error: ' . json_last_error_msg());
            }
            return $data;
        } catch (Exception $e) {
            // 错误处理
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * 将JSON数据转换为PHP对象。
     *
     * @param string $json JSON字符串
     * @return object|false 转换后的对象，或在失败时返回false
     */
    public function decodeJsonToObject($json) {
        try {
            // 使用JSON decode函数将JSON字符串转换为对象
            $data = json_decode($json);
            if (json_last_error() !== JSON_ERROR_NONE) {
                // 如果解码失败，抛出异常
                throw new Exception('JSON decode error: ' . json_last_error_msg());
            }
            return $data;
        } catch (Exception $e) {
            // 错误处理
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * 将PHP数组转换为JSON格式的字符串。
     *
     * @param array $array PHP数组
     * @return string|false JSON字符串，或在失败时返回false
     */
    public function encodeArrayToJson($array) {
        try {
            // 使用JSON encode函数将数组转换为JSON字符串
            $json = json_encode($array);
            if (json_last_error() !== JSON_ERROR_NONE) {
                // 如果编码失败，抛出异常
                throw new Exception('JSON encode error: ' . json_last_error_msg());
            }
            return $json;
        } catch (Exception $e) {
            // 错误处理
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * 将PHP对象转换为JSON格式的字符串。
     *
     * @param object $object PHP对象
     * @return string|false JSON字符串，或在失败时返回false
     */
    public function encodeObjectToJson($object) {
        try {
            // 使用JSON encode函数将对象转换为JSON字符串
            $json = json_encode($object);
            if (json_last_error() !== JSON_ERROR_NONE) {
                // 如果编码失败，抛出异常
                throw new Exception('JSON encode error: ' . json_last_error_msg());
            }
            return $json;
        } catch (Exception $e) {
            // 错误处理
            error_log($e->getMessage());
            return false;
        }
    }
}
