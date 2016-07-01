<?php
namespace app\index\logic\validate;
use think\Validate;

class User extends Validate
{
    protected $rule = [
        
        'uname'  =>  'require',
        'pass'   =>  'require',
        'email'  =>  'email|require',
    ];
    
    protected $message = [
        
        'uname.require'  =>  '用户名必须',
        'pass' => '密码不能为空',
        'email.email' =>  '邮箱格式错误',
        'email.require' =>  '邮箱不能为空'
    ];
    
    protected $scene = [
        'login'   =>  ['uname|email','pass'],
        'add'  =>  ['email','uname','pass'],
    ];
}

