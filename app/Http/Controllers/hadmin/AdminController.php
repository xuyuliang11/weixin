<?php

namespace App\Http\Controllers\hadmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
    	return view('hadmin.index');
    }
}
