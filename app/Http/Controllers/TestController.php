<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function getTestPage(Request $request){
        return('This is test page.');
    }
}
