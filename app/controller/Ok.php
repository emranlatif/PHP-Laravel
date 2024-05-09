<?php
namespace app\controller;

use app\BaseController;

class Ok extends BaseController
{
    public function index()
    {
        cookie('ok',time());
        return redirect('https://www.aeon.co.jp/');
    }
}
