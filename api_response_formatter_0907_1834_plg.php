<?php
// 代码生成时间: 2025-09-07 18:34:09
class ApiResponseFormatter {

    /**
     * Formats a success response.
     *
     * @param mixed $data The data to be returned in the response.
     * @param int $statusCode The HTTP status code for the response.
     * @return array The formatted API response.
     */
    public function formatSuccessResponse($data, $statusCode = 200) {
        return [
            'status' => 'success',
            'statusCode' => $statusCode,
            'data' => $data
        ];
    }

    /**
     * Formats an error response.
     *
     * @param string $message The error message.
     * @param int $statusCode The HTTP status code for the response.
     * @return array The formatted API error response.
     */
    public function formatErrorResponse($message, $statusCode = 400) {
        return [
            'status' => 'error',
            'statusCode' => $statusCode,
            'message' => $message
        ];
    }

    /**
     * Handles API responses by calling the appropriate formatter based on the response type.
     *
     * @param mixed $response The response to be formatted.
     * @param bool $isError Indicates whether the response is an error.
     * @param int|null $statusCode The HTTP status code for the response.
     * @return array The formatted API response.
     */
    public function handleResponse($response, $isError = false, $statusCode = null) {
        try {
            if ($isError) {
                return $this->formatErrorResponse($response, $statusCode);
            } else {
                return $this->formatSuccessResponse($response, $statusCode);
            }
        } catch (Exception $e) {
            // Handle unexpected errors
            return $this->formatErrorResponse('An unexpected error occurred.', 500);
        }
    }
}
