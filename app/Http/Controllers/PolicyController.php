<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function privacypolicy(){
        return view('staticpage.privacypolicy');
    }
    public function cancellationpolicy(){
        return view('staticpage.cancellationpolicy');
    }
    public function termscondition(){
        return view('staticpage.termscondition');
    }
    public function howitswork(){
        return view('staticpage.howitswork');
    }
    public function aboutus(){
        return view('staticpage.aboutus');
    }

}
