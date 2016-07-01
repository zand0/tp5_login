<?php
namespace app\index\model;

use think\Model;
/*
 * model层的User类
 * 
 */
class User extends Model
{
	//指定表明
	protected $table = 'user';
	//指定主键
	protected $pk = 'id';
	
}
?>