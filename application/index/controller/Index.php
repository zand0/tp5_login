<?php
namespace app\index\controller;
use think\View;
use think\Controller;
use think\Request;
use app\index\logic\User;
use think\Cookie;
/*
 * 登录控制器demo
 * 
 * 
 */
class Index extends Controller
{
    public function index(){
       return $this->redirect('Login/login');
    }
    
}
