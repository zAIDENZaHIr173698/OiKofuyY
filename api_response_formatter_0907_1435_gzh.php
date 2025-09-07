<?php
// 代码生成时间: 2025-09-07 14:35:40
class ApiResponseFormatter
{
    /**
     * Format the API response with success status and data.
# 添加错误处理
     *
     * @param mixed $data The data to be sent in the response.
     *
     * @return array
     */
    public function success($data)
    {
        return [
            'status' => 'success',
            'data' => $data
        ];
# 添加错误处理
    }

    /**
     * Format the API response with an error status and message.
     *
# 优化算法效率
     * @param string $message The error message to be sent in the response.
     * @param int $code The HTTP status code associated with the error.
     *
     * @return array
     */
    public function error($message, $code = 400)
    {
# 优化算法效率
        return [
            'status' => 'error',
            'message' => $message,
# 优化算法效率
            'code' => $code
        ];
    }
}

// Example usage:
// $formatter = new ApiResponseFormatter();
// $response = $formatter->success(['user' => 'John Doe']);
# FIXME: 处理边界情况
// or
// $response = $formatter->error('Something went wrong');
