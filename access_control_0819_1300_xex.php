<?php
// 代码生成时间: 2025-08-19 13:00:44
// AccessControl.php
// 权限控制类，用于管理用户的访问权限

class AccessControl {

    // 用户角色数组
    private $roles;

    // 构造函数，初始化角色
    public function __construct($roles) {
        $this->roles = $roles;
    }

    // 检查用户是否有权限访问某个资源
    public function hasAccess($resource) {
        // 检查角色是否为空
        if (empty($this->roles)) {
            // 返回false，没有角色，没有权限
            return false;
        }

        // 遍历角色，检查是否有权限
        foreach ($this->roles as $role) {
            if (in_array($resource, $role['permissions'])) {
                // 返回true，有权限访问该资源
                return true;
            }
        }

        // 如果没有找到匹配的权限，则返回false
        return false;
    }

    // 添加角色
    public function addRole($role) {
        // 添加角色到数组
        $this->roles[] = $role;
    }
}

// 使用示例
// 设置用户角色和权限
$userRoles = [
    [
        'name'      => 'admin',
        'permissions' => ['dashboard', 'settings', 'users']
    ],
    [
        'name'      => 'editor',
        'permissions' => ['dashboard', 'settings']
    ]
];

// 创建权限控制对象
$accessControl = new AccessControl($userRoles);

// 检查用户是否有权限访问dashboard
if ($accessControl->hasAccess('dashboard')) {
    echo 'Access granted to dashboard';
} else {
    echo 'Access denied to dashboard';
}
