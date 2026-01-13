<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(Auth::user()->role == 'Admin')
        {
            if ($request->ajax()) {
                $query = Account::with(['category_name'])->orderBy('id', 'desc');
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('category', function ($account) {
                        return $account->category_name ? $account->category_name->name : '-';
                    })
                    ->addColumn('password', function ($account) {
                            return '<span class="password-display" data-password="'.$account->password.'">
                                        <span class="password-mask">••••••••</span>
                                        <span class="password-text" style="display:none;">'.$account->password.'</span>
                                    </span>
                                    <a href="#" class="btn btn-sm ms-2 toggle-password">
                                        <i class="fa fa-eye"></i>
                                    </a>';
                        })
                    ->addColumn('note', function ($account) {
                            
                            if (!empty($account->note)) {
                                $url = route('account.note', $account->id);

                                return '
                                    <a href="javascript:void(0)"
                                    class="btn tbl-btn action-btn"
                                    data-url="'.$url.'"
                                    data-ajax-popup="true"
                                    data-size="md"
                                    data-title="Note"
                                    data-bs-toggle="tooltip"
                                    data-bs-original-title="View Note">
                                        <i class="fa fa-comment"></i>
                                    </a>
                                ';
                            }
                            else{
                                return '-';
                            }
                        })
                    ->addColumn('actions', function ($account) {
                        $buttons = '';
                        $editUrl = route('account.edit', $account->id);
                        $buttons .= '
                                <a href="#" class="btn btn-sm btn-secondary me-2" 
                                data-ajax-popup="true" data-size="md"
                                data-title="Edit Account" data-url="'.$editUrl.'"
                                data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                    <i class="fa fa-edit me-2"></i>Edit
                                </a>
                                ';
                        $deleteUrl = route('account.destroy', $account->id);
                        $buttons .= '
                                <button type="button" class="btn btn-sm btn-danger delete-btn"
                                    data-url="' . $deleteUrl . '"
                                    title="Delete">
                                    <i class="fa fa-trash me-2"></i> Delete
                                </button>
                                ';
                        
                            return $buttons;
                    })
                    ->rawColumns(['category','password','note','actions'])
                    ->make(true);
            }
        }else{
             if ($request->ajax()) {
                $query = Account::with(['category_name'])->where('created_by',Auth::user()->id)->orderBy('id', 'desc');
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('category', function ($account) {
                        return $account->category_name ? $account->category_name->name : '-';
                    })
                    ->addColumn('password', function ($account) {
                            return '<span class="password-display" data-password="'.$account->password.'">
                                        <span class="password-mask">••••••••</span>
                                        <span class="password-text" style="display:none;">'.$account->password.'</span>
                                    </span>
                                    <a href="#" class="btn btn-sm ms-2 toggle-password">
                                        <i class="fa fa-eye"></i>
                                    </a>';
                        })
                    ->addColumn('note', function ($account) {
                            
                            if (!empty($account->note)) {
                                $url = route('account.note', $account->id);

                                return '
                                    <a href="javascript:void(0)"
                                    class="btn tbl-btn action-btn"
                                    data-url="'.$url.'"
                                    data-ajax-popup="true"
                                    data-size="md"
                                    data-title="Note"
                                    data-bs-toggle="tooltip"
                                    data-bs-original-title="View Note">
                                        <i class="fa fa-comment"></i>
                                    </a>
                                ';
                            }
                            else{
                                return '-';
                            }
                        })
                    ->addColumn('actions', function ($account) {
                        $buttons = '';
                        $editUrl = route('account.edit', $account->id);
                        $buttons .= '
                                <a href="#" class="btn btn-sm btn-secondary me-2" 
                                data-ajax-popup="true" data-size="md"
                                data-title="Edit Account" data-url="'.$editUrl.'"
                                data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                    <i class="fa fa-edit me-2"></i>Edit
                                </a>
                                ';
                        $deleteUrl = route('account.destroy', $account->id);
                        $buttons .= '
                                <button type="button" class="btn btn-sm btn-danger delete-btn"
                                    data-url="' . $deleteUrl . '"
                                    title="Delete">
                                    <i class="fa fa-trash me-2"></i> Delete
                                </button>
                                ';
                        
                            return $buttons;
                    })
                    ->rawColumns(['category','password','note','actions'])
                    ->make(true);
            }
        }

        return view('account.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->role == 'Admin')
        {
            $categories = Category::get();
        }else{
            $categories = Category::where('created_by',Auth::user()->id)->get();
        }
        
        return view('account.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Account::class],
            'password' => ['required', 'string'],
            'category' => ['required', 'string'],
            'note' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
        $account = new Account();
        $account->email = $request->email;
        $account->password = $request->password;
        $account->category = $request->category;
        $account->note = $request->note;
        $account->created_by = Auth::user()->id;
        $account->save();

        return redirect()->route('account.index')->with('success', 'Account created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        if(Auth::user()->role == 'Admin')
        {
            $categories = Category::get();
        }else{
            $categories = Category::where('created_by',Auth::user()->id)->get();
        }
        
        return view('account.edit', compact('account','categories'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account)
    {
         $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Account::class.',email,'.$account->id],
            'password' => ['required', 'string'],
            'category' => ['required', 'string'],
            'note' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
        $account->email = $request->email;
        $account->password = $request->password;
        $account->category = $request->category;
        $account->note = $request->note;
        $account->save();
        return redirect()->route('account.index')->with('success', 'Account updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        $account->delete();
        return redirect()->route('account.index')->with('success', 'Account deleted successfully.');
    }

    /**
     * Show password in popup.
     */
    public function viewPassword(Account $account)
    {
        return view('account.view-password', compact('account'));
    }

    public function note($id)
    {
        $account = Account::findOrFail($id);
        return view('account.note', compact('account'));
    }
}
