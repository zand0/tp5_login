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
    
    public function test(){
        $img = [
            'http://avatar.csdn.net/D/6/2/1_voteon83.jpg',
        ];
        $res = [];
        for ($i=0;$i<5;$i++){
            $res[]=[
                'name'=>'王小红'.$i,
                'avater'=>$img[0],
                'date'=>date('Y/m/d',time())
            ];
        }
    
        return json($res);
    
    }
    
}
