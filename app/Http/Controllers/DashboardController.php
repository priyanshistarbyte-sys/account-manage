<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Account;
use Illuminate\Http\Request;
use Lab404\Impersonate\Impersonate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::user()->role == 'Admin')
        {
            $categoryCount = Category::count();
            $accountCount  = Account::count();
            $userCount     = User::where('id','!=',Auth::user()->id)->count();
            $categories    = Category::get();
        }else{
            $categoryCount = Category::where('created_by',Auth::user()->id)->count();
            $accountCount  = Account::where('created_by',Auth::user()->id)->count();
            $userCount     = User::where('created_by',Auth::user()->id)->count();
            $categories    = Category::where('created_by',Auth::user()->id)->get();
        }
        
        return view('dashboard', compact('categoryCount', 'accountCount','userCount', 'categories'));
    }

    public function getCategoryAccounts($categoryId)
    {
        $accounts = Account::where('category', $categoryId)
                    ->where('created_by', Auth::user()->id)
                    ->select('email', 'password','note')
                    ->get();
        return view('category_account', compact('accounts'));
    }



    public function loginWithAccount(Request $request, $id)
    {
       
        $user = \App\Models\User::find($id);
        
        if (!$user) {
            abort(404, 'User not found');
        }
        // Verify token from main-site
        $expectedToken = hash_hmac('sha256', $id, env('APP_KEY'));
        if (!hash_equals($expectedToken, $request->query('token'))) {
            abort(403, 'Invalid signature.');
        }
        // Log in user
        \Auth::login($user, true);
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard'))->with('success', 'Logged in successfully!');
    }
}
