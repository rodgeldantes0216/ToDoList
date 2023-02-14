<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Todo;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $get_todo_data = Todo::where("active_status", 1)->where('user_id', Auth::id())->get();

        // return $get_todo_data;

        return view('home')->with('todos', $get_todo_data);//, ['todos', $get_todo_data]);
    }
}
