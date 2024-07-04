<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DatabaseServiceController extends Controller
{
    public function index()
    {
        return view('customer.database.services.index');
    }
}
