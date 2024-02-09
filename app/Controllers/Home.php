<?php

namespace App\Controllers;

use Ramsey\Uuid\Uuid;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'menu' => 'dashboard',
            'sub' => '',
            'db' => Uuid::uuid4()->toString()
        ];
        return view('admin/dashboard',$data);
    }
}
