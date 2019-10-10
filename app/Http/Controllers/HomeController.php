<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Role;

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
        // return view('home');
        $user = Auth::user();
        // $role = Role::where('id', $user->role_id)->first();

        if ($user->role->name == "admin") {
            return redirect ('/admin/dashboard');
        }
        elseif ($user->role->name == "operator") {
            return redirect()->route('operator.dashboard');
        }else{
            return redirect()->route('manajer.dashboard');
            // echo "sukses login";
            // Auth::logout();
        }
    }
}
