<?php
namespace app\index\controller;
use think\View;
use \think\Controller;
use \think\Request;
use app\index\logic\User;
use app\index\lib\test;
use think\Cookie;
use think\Session;
use think\Hook;
use app\index\logic\api\Email;
//use app\index\logic\util\UtilStr;


/*
 * 登录控制器demo
 * 
 * 
 */

class Login extends Controller
{
	/**
	 * 登录操作,三个参数为绑定参数，自动获取同名get或post参数
	 * 返回值 
	 * @param string $submit 自动接收，
	 * @param string $account 自动接收，可以是用户名或邮箱
	 * @param string $pass 自动接收，
	 * @author 史坤强
	 * date 2016-7-1
	 */
	public function login($submit='',$account='',$pass=''){
	    
	    $this->is_login();
		if($submit){
		    //组建要验证的数据集
		    $data = [];
		    $data['uname']='';
		    $data['email']='';
		    $data['pass']=$pass;
			if(strstr($account,'@')){
			    $data['email'] = $account;
			}else{
			    $data['uname'] = $account;
			}
			//实例化app\index\logic层的User
			$user_logic = new User;
			//验证提交数据
			$result = $user_logic->validate($data,[],'login');
			if(!empty($result)){
			    // 验证失败 输出错误信息
			    return $this->error($result);
			}
			//调用User的方法判断验证登录
			if($user_logic->select_pass_check($account,$pass)){
				return $this->success('登录成功','/index.php/index/Login/ucenter');
			}else{
				return $this->error('登录失败');
			}
		}
		return $this->fetch('login/login');
	}
	public function test(){
	    //return UtilStr::rand();
	    $mail = new Email();
	    $mail->setServer("smtp.sina.com", "shikunqiang@sina.com", "209833.dnfhs");
	    $mail->setFrom("shikunqiang@sina.com");
	    $mail->setReceiver("1009735870@qq.com");
	    //$mail->setReceiver("XXXXX@XXXXX");
	    //$mail->setCc("675517302@qq.com");
	    //$mail->setCc("");
	    //$mail->setBcc("675517302@qq.com");
	    //$mail->setBcc("");
	    //$mail->setBcc("");
	    $mail->setMailInfo("test", "<a href=\"http://baidu.com\">baidu</a>", "");
	    $mail->sendMail();
	}
	/**
	 * 判断用户是否为登录状态
	 * @author 史坤强
	 * date 2016-7-1
	 */
	public function is_login(){
	    $uname = Cookie::get('uname');
	    if($uname){
	        //实例化app\index\logic层的User
	        $user_logic = new User;
	        if(User::is_login($uname)){
	            return $this->redirect('Login/ucenter');
	        }
	    }  
	}
	//模拟用户中心
	public function ucenter(){
	    //$this->is_login();
		return $this->fetch('login/ucenter');
	}
	/**
	 * 执行登出
	 * @author 史坤强
	 * date 2016-7-1
	 */
	public function logout(){
	    Session::delete('uname');
	    Cookie::delete('uname');
	    return $this->redirect('login/login');
	}
}
