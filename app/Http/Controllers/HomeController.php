<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index(){
        echo '<pre>' , var_dump('aaaa') , '</pre>';die;
    }
    //
}
