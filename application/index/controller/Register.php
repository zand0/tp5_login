<?php
namespace app\index\controller;
use think\View;
use think\Controller;
use think\Request;
use app\index\logic\User;
use think\Cookie;
use app\index\logic\Xml;
/**
 * 注册控制器
 * @author 史坤强
 *
 */
class Register extends Controller
{
   /**
    * 注册操作
    * @param string $submit 自动获取表单的同名参数
    * @param string $uname 自动获取表单的同名参数
    * @param string $email 自动获取表单的同名参数
    * @param string $pass 自动获取表单的同名参数
    * @author 史坤强
    * date 2016-7-1
    */
    public function reg($submit='',$uname='',$email='',$pass=''){
        $this->is_login();
		//获取整个post数据
    	$user = Request::instance()->post();
    	$user['uptime'] = time();
    	if($submit){
    		
	    	//实例化app\index\logic层的User
	    	$user_logic = new User;
	    	//验证提交数据
	    	$result = $user_logic->validate($user,[],'add');
	    	if(!empty($result)){
	    	    // 验证失败 输出错误信息
	    	    return $this->error($result);
	    	}
	    	if($user_logic->insert_addUser($user)){
	    		return $this->success('注册成功','/index.php/index/Login/ucenter');
	    	}else{
	    		return $this->error('用户名或邮箱已存在','/index.php/index/Register/reg');
	    	}
    	}
    	$x = new Xml;
    	$provinces = $x->read_dom('./static/Provinces.xml')->read_getProvince();
    	$this->assign('provinces',$provinces);
    	return $this->fetch('reg/reg');
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
    /**
     * 邮件激活
     * @param string $uname
     * @param string $code
     * @author 史坤强
     * date 2016-7-1
     */
    public function activate($uname='',$code=''){
        //实例化app\index\logic层的User
        $user_logic = new User;
        if($user_logic->activate($uname,$code)){
            return $this->success('激活成功','/index.php/index/Login/login');
        }else{
            return $this->error('激活失败','/index.php/index/Register/reg');
        }
    }
    
    public function city($pid){
        $cities = [];
        if($pid){
            $x = new Xml;
            $cities = $x->read_dom('./static/Cities.xml')->read_getCity($pid);
        }
        return json($cities);
    }
}
