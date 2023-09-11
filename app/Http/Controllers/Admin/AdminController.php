<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function menu(){
        dd('test admin controller');
        return 'admin menu';
    }
}
