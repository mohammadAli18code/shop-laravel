<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request, $role = 'all')
    {
        $filters = $request->only(['id' , 'first_name' , 'last_name' , 'email' , 'phone']);

        $users = User::filterByRole($role)
                    ->filter($filters)
                    ->paginate(15);

        if ($request->ajax()) {
            return view('admin.users._table', compact('users'))->render();
        }

        return view('admin.users.index', compact('users', 'role'));
    }


    // public function index($role = 'all')
    // {
    //     $users = User::filterByRole($role)->get();


    //     if ($request->ajax()){
    //         return view('admin.users._table', compact('users'))->render();
    //     }
    //         return view('admin.users.index', compact('users', 'role'));
    //     // $users = User::when($role !== 'all' && $role !== 'activeCustomers' && $role !== 'notActiveCustomers', function ($query) use ($role) {
    //     //     $query->where('role', $role);
    //     // })->get();
    //     return view('admin.users.index', compact('users', 'role'));

    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.userInfo' , compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
