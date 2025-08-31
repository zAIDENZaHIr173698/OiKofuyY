<?php
// 代码生成时间: 2025-08-31 11:57:22
class FormValidator {

    /**
     * 表单数据
     *
     * @var array
     */
    private $data;

    /**
     * 验证规则
     *
     * @var array
     */
    private $rules;

    /**
     * 错误信息
     *
     * @var array
     */
    private $errors = [];

    /**
     * 构造函数，初始化表单数据和验证规则
     *
     * @param array $data 表单数据
     * @param array $rules 验证规则
     */
    public function __construct(array $data, array $rules) {
        $this->data = $data;
        $this->rules = $rules;
    }

    /**
     * 验证表单数据
     *
     * @return bool
     */
    public function validate() {
        foreach ($this->rules as $field => $rule) {
            foreach ($rule as $validator) {
                if (!$this->applyValidator($field, $validator)) {
                    $this->errors[$field][] = $validator['message'];
                }
            }
        }

        return empty($this->errors);
    }

    /**
     * 应用验证器
     *
     * @param string $field 字段名
     * @param array $validator 验证器配置
     * @return bool
     */
    private function applyValidator($field, array $validator) {
        $value = isset($this->data[$field]) ? $this->data[$field] : null;

        switch ($validator['type']) {
            case 'required':
                return !empty($value);
            case 'email':
                return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
            case 'max_length':
                return strlen($value) <= $validator['length'];
            default:
                return true;
        }
    }

    /**
     * 获取错误信息
     *
     * @return array
     */
    public function getErrors() {
        return $this->errors;
    }
}

// 使用示例
$data = [
    'name' => 'John Doe',
    'email' => 'johndoe@example.com',
    'age' => '30'
];

$rules = [
    'name' => [
        ['type' => 'required', 'message' => 'Name is required']
    ],
    'email' => [
        ['type' => 'required', 'message' => 'Email is required'],
        ['type' => 'email', 'message' => 'Invalid email format']
    ],
    'age' => [
        ['type' => 'max_length', 'length' => 3, 'message' => 'Age must be less than 3 characters']
    ]
];

$validator = new FormValidator($data, $rules);
if ($validator->validate()) {
    echo 'Validation successful';
} else {
    echo 'Validation failed';
    print_r($validator->getErrors());
}
