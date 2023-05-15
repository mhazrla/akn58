<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class LayoutController extends BaseController
{
    public function index()
    {
        return view("layout/home");
    }
}
