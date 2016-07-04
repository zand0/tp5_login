<?php
namespace app\index\logic;
use app\index\model\User as UserModel;
use think\Session;
use think\Cookie;
use app\index\logic\util\UtilStr;
use app\index\logic\validate\User as VUser;
use app\index\logic\api\Email;
/*
 * logic层的User
 * 
 */
class User {
	/**
	 * 检查密码是否正确，如正确执行登录
	 * @param  $data 用户名/邮箱
	 * @param  $pass 密码
	 * @return 布尔 
	 */
	public function select_pass_check($account,$pass){
	    
	    $user_model = new UserModel;
	    $user_info = $this->select_UserInfoByAccount($account);
	    //获得加密pass 字符串
		$pass = md5(md5($pass).$user_info['salt']);
		//对比表中密码和传来的密码是否相同
		if($user_info && $user_info['pass']==$pass){
		    //设置session和cookie
		    Session::set($user_info['uname'],$user_info['id']);
		    Cookie::set('uname',$user_info['uname'],600);
			return 1;
		}else{
			return 0;
		}
	}
	/**
	 * 增加一个用户
	 * 返回 成功返回true失败返回false
	 * @param array $user 包含注册信息的post集合
	 * @author 史坤强
	 * date 2016-7-1
	 */
	public function insert_addUser($user){
		if(!$this->select_user_check($user)){
		    //生成4位随机字符串
		    $user['salt'] = UtilStr::rand();
		    //加密密码
		    $user['pass'] = md5(md5($user['pass']).$user['salt']);
		    $user['status'] = 0;
		    $user['emailsig'] = UtilStr::rand(8);
		    $user['emailsig_time'] = time();
		    $code = $user['emailsig'];
			//实例化model层的User
			$user_model = new UserModel($user);
			//$user_model->data($user);
			//发送确认邮件
			$title = '注册成功确认邮件';
			$body = '<a href="'.url('http://'.$_SERVER['HTTP_HOST'].'/index.php/index/Register/activate/code/'.$code.'/uname/'.$user['uname']).'">'.$code.'</a>';
			$this->sendEmail('shikunqiang@miaozhunpin.com',$user['email'],$title,$body);
			return $user_model->allowField(['id','uname','pass','uptime','email','salt','emailsig','emailsig_time'])
			                  ->save();
		}else{
			return false;
		}
		
	}
	/**
	 * 通过帐号（帐号包括邮箱或用户名）获取用户信息
	 * @param string $account
	 * @return array 返回用户信息的集合
	 * @author 史坤强
	 * date 2016-7-1
	 */
	public function select_UserInfoByAccount($account){
		//实例化model层的User
		$user_model = new UserModel;
		//调用User方法查询数据库，获取用户信息
		if(strstr($account,'@')){
		    //通过用户名查找用户信息
		    $user_info = $user_model->where('email',$account)->where('status',1)->find();
		}else{
		    //通过email查找用户信息
		    $user_info = $user_model->where('uname',$account)->where('status',1)->find();
		}
		return $user_info;
	}
	/**
	 * 检查用户唯一性
	 * @param array $res 用户信息集合
	 * @return boolean 用户已存在返回true，否则false
	 * @author 史坤强
	 * date 2016-7-1
	 */
	public function select_user_check($res){
	    //实例化model层的User
	    $user_model = new UserModel;
		$user_info = $user_model->where('uname',$res['uname'])->whereOr('email',$res['email'])->find();
		if($user_info['id']){
			return 1;
		}else{
			return 0;
		}
	}
	/**
	 * 判断用户是否为登录状态
	 * @param string $uname
	 * @return boolean 是登录状态返回true，否则false
	 * @author 史坤强
	 * date 2016-7-1
	 */
	public static function is_login($uname=''){
	    if(!$uname){
	        $uname = Cookie::get('uname');
	    }
	    if(Session::get($uname)){
	        return 1;
	    }else{
	        return 0;
	    }
	}
	/**
	 * 验证数据
	 * @param array $data
	 * @param array $rules
	 * @param string $scene
	 * @author 史坤强
	 */
	public function validate($data,$rules = [], $scene = ''){
	    $vali = new VUser();
	    
	    if(!$vali->check($data,$rules,$scene)){
	       return  $vali->getError();
	    }
	}
	/**
	 * 邮件认证
	 * @param string $uname
	 * @param string $code
	 * @return number
	 * @author 史坤强
	 * date 2016-7-1
	 */
	public function activate($uname,$code){
	    //实例化model层的User
	    $user_model = new UserModel;
	    if($uid = $user_model->where('uname',$uname)->where('emailsig',$code)->value('id')){
	        $user_model->save(['status'=>1],['id'=>$uid]);
	        return 1;
	    }else{
	        return 0;
	    }
	}
	/**
	 * 发送邮件
	 * @param string $from
	 * @param string $to
	 * @param string $title
	 * @param string $body
	 * @author 史坤强
	 * date 2016-7-1
	 */
	public function sendEmail($from,$to,$title,$body){
	    $mail = new Email();
	    $mail->setServer("smtp.miaozhunpin.com", "shikunqiang@miaozhunpin.com", "0453.miaozhun");
	    $mail->setFrom($from);
	    $mail->setReceiver($to);
	    //$mail->setReceiver("XXXXX@XXXXX");
	    //$mail->setCc("675517302@qq.com");
	    //$mail->setCc("");
	    //$mail->setBcc("675517302@qq.com");
	    //$mail->setBcc("");
	    //$mail->setBcc("");
	    $mail->setMailInfo($title, $body, "");
	    $mail->sendMail();
	}
	
}