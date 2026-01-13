<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Crypt;


class UserController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::user()->role == 'Admin')
        {
            if ($request->ajax()) {
                $query = User::where('id','!=',Auth::user()->id)->orderBy('id', 'desc');
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('actions', function ($user) {
                        $buttons = '';
                        $editUrl = route('user.edit', $user->id);
                        $buttons .= '
                                <a href="#" class="btn btn-sm btn-secondary me-2" 
                                data-ajax-popup="true" data-size="md"
                                data-title="Edit User" data-url="'.$editUrl.'"
                                data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                    <i class="fa fa-edit me-2"></i>Edit
                                </a>
                                ';
                        $deleteUrl = route('user.destroy', $user->id);
                        $buttons .= '
                                <button type="button" class="btn btn-sm btn-danger delete-btn"
                                    data-url="' . $deleteUrl . '"
                                    title="Delete">
                                    <i class="fa fa-trash me-2"></i> Delete
                                </button>
                                ';
                        
                            return $buttons;
                    })
                    ->rawColumns(['actions'])
                    ->make(true);
            }
        } else{
            if ($request->ajax()) {
            $query = User::where('created_by',Auth::user()->id)->orderBy('id', 'desc');
            return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('actions', function ($user) {
                        $buttons = '';
                        $editUrl = route('user.edit', $user->id);
                        $buttons .= '
                                <a href="#" class="btn btn-sm btn-secondary me-2" 
                                data-ajax-popup="true" data-size="md"
                                data-title="Edit User" data-url="'.$editUrl.'"
                                data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                    <i class="fa fa-edit me-2"></i>Edit
                                </a>
                                ';
                        $deleteUrl = route('user.destroy', $user->id);
                        $buttons .= '
                                <button type="button" class="btn btn-sm btn-danger delete-btn"
                                    data-url="' . $deleteUrl . '"
                                    title="Delete">
                                    <i class="fa fa-trash me-2"></i> Delete
                                </button>
                                ';
                        
                            return $buttons;
                    })
                    ->rawColumns(['actions'])
                    ->make(true);
            }
        }

        return view('users.index');
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
        $user             = new User();
        $user->name       = $request->name;
        $user->email      = $request->email;
        $user->password   = $request->password;
        $user->role       = 'User';
        $user->created_by = Auth::user()->id;
        $user->save();

        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }

    public function show(User $User)
    {
        return redirect()->back();
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
         $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',email,'.$user->id],
            'password' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
        $user->name       = $request->name;
        $user->email      = $request->email;
        if ($request->filled('password')) {
            $user->password = $request->password;
        }
        $user->save();
        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }


}
