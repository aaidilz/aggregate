<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;

class DatabasePartController extends Controller
{
    public function index()
    {
        $parts = Part::Paginate(10);
        $partTypes = Part::select('part_type')->distinct()->get();
        return view('parts.index', compact('parts', 'partTypes'));
    }
}
