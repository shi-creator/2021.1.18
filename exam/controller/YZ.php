<?php

namespace app\exam\controller;

use think\Controller;
use think\Request;
use think\Validate;

class YZ extends Validate
{
    protected $rule = [
        'title'  =>  'require'
    ];
}
