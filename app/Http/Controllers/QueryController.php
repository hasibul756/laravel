<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryController extends Controller
{
    public function index() {
        // $users = DB::table('users')->get();
        $users = DB::select('SELECT * FROM users');
        return view('query.index',compact('users'));
    }
}
