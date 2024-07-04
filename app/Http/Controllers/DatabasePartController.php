<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DatabasePartController extends Controller
{
    public function index()
    {
        return view('customer.database.parts.index');
    }
}
