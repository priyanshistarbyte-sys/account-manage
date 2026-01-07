<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Lab404\Impersonate\Impersonate;

class DashboardController extends Controller
{
    public function index()
    {
        $categoryCount = \App\Models\Category::count();
        $accountCount = \App\Models\Account::count();

        return view('dashboard', compact('categoryCount', 'accountCount'));
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
