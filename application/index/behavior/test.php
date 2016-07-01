<?php
namespace app\index\behavior;

class test
{
    public function action_begin(&$params)
    {
        dump($params);
        //return 'hello';
    }
}

