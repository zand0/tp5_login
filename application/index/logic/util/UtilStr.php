<?php
namespace app\index\logic\util;
/*
 * 类
 * 有关字符串的工具方法
 * @author shikunqiang
 *
 */
class UtilStr
{
    /*
     * 获取指定长度的随机字符串
     * 返回值 指定位数的随机字符串
     * @param int $l 想要返回的字符串长度
     * @author shikunqiang
     * date 2016-6-30
     */
    public static function rand($l=4){
        $rand = '';
        $c= "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        //srand((double)microtime()*1000000);
        for($i=0; $i<$l; $i++) {
            $rand.= $c[mt_rand(0,strlen($c)-1)];
        }
        return $rand;
    } 
}

