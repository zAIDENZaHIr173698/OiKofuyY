<?php
// 代码生成时间: 2025-09-15 22:24:09
// 用户身份认证类
class UserAuth {

    // 用户数据库连接
    private $db;

    // 构造函数，初始化数据库连接
    public function __construct($db) {
        $this->db = $db;
    }

    // 用户登录验证
    public function login($username, $password) {
        // 检查用户名和密码是否为空
        if (empty($username) || empty($password)) {
            throw new Exception('用户名或密码不能为空');
        }

        // 从数据库获取用户信息
        $user = $this->getUserFromDb($username);

        // 验证用户是否存在
        if (!$user) {
            throw new Exception('用户不存在');
        }

        // 验证密码是否正确
        if (!$this->verifyPassword($password, $user['password'])) {
            throw new Exception('密码错误');
        }

        // 登录成功，返回用户信息
        return $user;
    }

    // 从数据库获取用户信息
    private function getUserFromDb($username) {
        try {
            $stmt = $this->db->prepare('SELECT * FROM users WHERE username = :username');
            $stmt->execute(['username' => $username]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('数据库查询错误：' . $e->getMessage());
        }
    }

    // 验证密码是否正确
    private function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

}

// 使用示例
try {
    // 假设已有数据库连接实例$db
    $auth = new UserAuth($db);
    $user = $auth->login('testuser', 'testpassword');
    echo '登录成功：' . $user['username'];
} catch (Exception $e) {
    echo '登录失败：' . $e->getMessage();
}
